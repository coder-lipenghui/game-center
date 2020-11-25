<?php


namespace backend\models\ops;

use backend\models\TabGames;
use PHPUnit\Framework\Exception;
use Yii;
use backend\models\TabServers;
use common\helps\CurlHttpClient;
use yii\base\Model;

class MergerModel extends Model
{
    public $gameId;
    public $distributorId;
    public $activeServerId;//
    public $passiveServerId;//
    public $type=1;
    //kz]QXa4i&$Ha*68,!C7H25x73Xr!xTV@
    public $secretKey='kz]QXa4i&$Ha*68,!C7H25x73Xr!xTV@';
    public $version='10002';
    public function rules()
    {
        return [
            [['gameId','distributorId','activeServerId','passiveServerId','type'],'required'],
            [['gameId','distributorId','activeServerId','passiveServerId','type'],'integer'],
        ];
    }

    /**
     * 数据库打包
     * @return array
     */
    public function package()
    {

        set_time_limit(0);
        $result = $this->getParams();
        if ($result && !empty($result['data']))
        {
            $post = $result['data'];
            $post['doit'] = 'environment_ver';
            $activeUrl = $post['activeUrl'];
            $passiveUrl = $post['passiveUrl'];
            unset($post['activeUrl'], $post['passiveUrl'], $post['hqUrl']);

            //日志记录，规避重复操作
            //如果这次的主动区已经合过了则跳过
            $mergeLog = TabOpsMergeLog::find()->where(['activeUrl' => $activeUrl])->one();
            if ($mergeLog) {
                return ['code' => -1, 'msg' => '主动区已经合过至少一次，确定需要再次合区 请清理对应的日志数据!'];
            } else {
                $mergeLog = new TabOpsMergeLog();
                $mergeLog->gameId = $this->gameId;
                $mergeLog->distributionId = $this->distributorId;
                $mergeLog->activeUrl = $activeUrl;
                $mergeLog->passiveUrl = $passiveUrl;
                $mergeLog->uid = Yii::$app->user->id;
                $mergeLog->logTime = date('Y-m-d H:i:s', time());
                if (!$mergeLog->save()) {
                    return ['code' => -1, 'msg' => '合区日志记录失败', 'data' => $mergeLog->getErrors()];
                }
                //主动区
                $curl = new CurlHttpClient();
                $activeJson = $curl->sendPostData($activeUrl, $post, null, 30);
                $activeJsonArr = json_decode($activeJson, true);

                if ($activeJsonArr['res'] === 'true') {
                    if ($activeJsonArr['msg']['df_use'] > 2000) {
                        return ['code' => -1, 'msg' => '主动区服务器数据库超过2G,请优化后合区!'];
                    }
                    if ($activeJsonArr['msg']['net_ver'] != 'close') {
                        return ['code' => -1, 'msg' => '主动区服引擎未退出,请在退出引擎后合区!'.$activeJsonArr['msg']['netport']];
                    }
                } elseif ($activeJsonArr['res'] === 'false') {
                    return ['code' => -1, 'msg' => $activeJsonArr['msg']];
                } else {
                    return ['code' => -1, 'msg' => '主动区地址不存在:' . $activeUrl.json_encode($activeJsonArr)];
                }
                //被动区
                $curl = new CurlHttpClient();
                $passiveJson = $curl->sendPostData($passiveUrl, $post, null, 20);
                $passiveJsonArr = json_decode($passiveJson, true);
                if ($passiveJsonArr['res'] === 'true') {
                    if ($passiveJsonArr['msg']['net_ver'] != 'close') {
                        return ['code' => -1, 'msg' => '被动区服引擎未退出,请在退出引擎后合区!'];
                    }
                } elseif ($passiveJsonArr['res'] === 'false') {
                    return ['code' => -1, 'msg' => $passiveJsonArr['msg']];
                } else {
                    return ['code' => -1, 'msg' => '被动区地址不存在:' . $passiveUrl];
                }
                $curl = null;

                $post['doit'] = 'log_and_zip';
                $curl = new CurlHttpClient();
                $json = $curl->sendPostData($activeUrl, $post, null, 20);

                $jsonArr = json_decode($json, true);
                if ($jsonArr['res'] === 'true') {
                    return ['code' => 1, 'msg' => 'success'];
                } elseif ($jsonArr['res'] === 'false') {
                    return ['code' => -1, 'msg' => $jsonArr['msg']];
                } else {
                    return ['code' => -1, 'msg' => '系统错误:' . $activeUrl];
                }
            }
        } else {
            return $result;
        }
    }

    /**
     * 合并数据库
     * 1.从主动区下载游戏数据mysql.zip文件
     * 2.合并数据
     */
    public function merge()
    {
        $result=$this->getParams();
        if ($result && !empty($result['data']))
        {
            //下载mysql.zip文件
            $post=$result['data'];
            $post['doit']   = 'down_and_hq';
            $passiveUrl = $post['passiveUrl'];
            $hqUrl=$post['hqUrl'];
            unset($post['activeUrl'], $post['passiveUrl'], $post['hqUrl']);

            $curl=new CurlHttpClient();
            $mergeJson=$curl->sendPostData($passiveUrl,$post);
            $curl=null;
            $mergeJsonArr=json_decode($mergeJson,true);

            if ($mergeJsonArr['res'] === 'true') {
                //开始合并数据
                //TODO 数据库增加一个字段"是否清理行会数据"
                $cleanGuild='Y';
                $post['guild_stat'] = $cleanGuild;
                $post['ticket']     = md5($post['srcarea'] . $post['desarea'] . $this->secretKey . $this->version);
                $curl=new CurlHttpClient();
                $mergeResult=$curl->sendPostData($hqUrl,$post);
                switch ($mergeResult)
                {
                    case "-1":
                        return ['code'=>-1,'msg'=>'参数错误'];
                        break;
                    case "-2":
                        return ['code'=>-1,'msg'=>'IP拒绝访问'];
                        break;
                    case "PRE:预处理失败":
                        return ['code'=>-1,'msg'=>'更改区服状态失败'];
                        break;
                    case 'sql error 01':
                        return ['code'=>-1,'msg'=>'处理玩家信息出现异常'];
                        break;
                    case 'sql error 02':
                        return ['code'=>-1,'msg'=>'处理行会信息出现异常'];
                        break;
                    case'true':
                        return ['code'=>1,'msg'=>'success'];
                        break;
                    default:
                        return ['code'=>-1,'msg'=>'未知异常:'.$mergeResult.$hqUrl];
                }

            } elseif ($mergeJsonArr['res'] === 'false') {
                exit($mergeJsonArr['msg']);
            } else {
                exit('sys error02'.json_encode($mergeJsonArr));
            }
        }else{
            $result['info']=$this->getErrors();
            $result['msg']="数据验证失败";
            return $result;
        }
    }

    /**
     * 处理重名
     */
    public function rename(){
        $result=$this->getParams();
        if ($result && !empty($result['data']))
        {
            $post=$result['data'];
            $passiveUrl = $post['passiveUrl'];
            $post['doit']   = 'download_hqgm';
            unset($post['activeUrl'], $post['passiveUrl'], $post['hqUrl']);

            $curl=new CurlHttpClient();

            $renameJson=$curl->sendPostData($passiveUrl,$post);
            $renameJsonArr=json_decode($renameJson,true);
            if ($renameJsonArr['res'] === 'true') {
                $server=TabServers::find()->where(['id'=>$this->activeServerId])->one();
                $server->mergeId=$this->passiveServerId;
                $server->save();
                return ['code'=>1,'msg'=>'success'];
            } elseif ($renameJsonArr['res'] === 'false') {
                switch ($renameJsonArr['msg'])
                {
                    case "ftp connect error05":
                    case "ftp user error05":
                    case "ftp path error05":
                    case "list ftp file error05":
                    case "file not exists error05":
                    case "file not exists error05":
                    case "local file exists error05":
                    case "get hequgmsys error05":
                    case "extract zip error":
                        return ['code'=>-2,'msg'=>$renameJsonArr['msg']];
                        break;
                    default:
                        return ['code'=>-3,'msg'=>$renameJsonArr['msg']];
                }
            } else {
                return ['code'=>-1,'msg'=>'系统错误'];
            }
        }else{
            return $result;
        }
    }
    /**
     * 获取必要参数
     * @return mixed
     */
    private function getParams()
    {
        $result=['code'=>-1,'msg'=>'','data'=>null];
        $request=Yii::$app->request;
        $this->load($request->queryParams);
        if ($this->validate()) {
//            if ($this->type != 0) {
                $passiveServer=TabServers::find()->where(['id'=>$this->passiveServerId])->one();
                $activeServer=TabServers::find()->where(['id'=>$this->activeServerId])->one();
                $game=TabGames::find()->where(['id'=>$this->gameId])->one();
                if ($game)
                {
                    if ($passiveServer && $activeServer) {

                        $activeUrl = 'http://' . $activeServer->url . '/adminweb/dao/hequ_client.php';//active
                        $passiveUrl = 'http://' . $passiveServer->url . '/adminweb/dao/hequ_client.php';//passive
                        $hqUrl = 'http://' . $passiveServer->url . '/adminweb/dao/merger_chr.php';
                        $result['data']=[];
                        $result['data']['ticket'] = md5($activeServer->url . $passiveServer->url . $this->secretKey);
                        $result['data']['game_id'] = strtolower($game->sku);
                        $result['data']['activeUrl']=$activeUrl;
                        $result['data']['passiveUrl']=$passiveUrl;
                        $result['data']['hqUrl']=$hqUrl;
                        $result['data']['srcarea'] = $activeServer->url;
                        $result['data']['desarea'] = $passiveServer->url;
                    }else{
                        $result['code']=-1;
                        $result['msg']='区服不存在';
                    }
                }else{
                    $result['code']=-1;
                    $result['msg']='游戏不存在';
                }
//            }
        }else{
            $result['code']=-1;
            $result['msg']='参数错误';
        }
        return $result;
    }
    /**
     * 半自动合区模式
     */
    private function semiauomatic()
    {
//        $this->preParam(I('post.')) or die('Param Error04');
//        $post  = $this->postparam;
//        $where = array(
//            'srcarea' => $this->srcarea,
//        );
//        $mergeLog=TabOpsMergeLog::find()->where(['activeUrl'=>$activeUrl])->one();
//        if ($mergeLog)
//        {
//            return ['code'=>-1,'msg'=>'主动区已经合过至少一次，确定需要再次合区 请清理对应的日志数据!'];
//        }else{
//            $mergeLog=new TabOpsMergeLog();
//            $mergeLog->gameId=$this->gameId;
//            $mergeLog->distributionId=$this->distributorId;
//            $mergeLog->activeUrl=$activeUrl;
//            $mergeLog->passiveUrl=$passiveUrl;
//            $mergeLog->uid=Yii::$app->user->id;
//            $mergeLog->logTime=date('Y-m-d H:i:s',time());
//            if(!$mergeLog->save())
//            {
//                return ['code'=>-1,'msg'=>'合区日志记录失败','data'=>$mergeLog->getErrors()];
//            }
//
//        }
//        $where = array(
//            'game_id' => $this->game_id,
//        );
//        $res_guild_stat     = M('game')->where($where)->field("guild_stat")->find();
//        $post['guild_stat'] = $res_guild_stat['guild_stat'];
//        $post['ticket']     = md5($this->srcarea . $this->desarea . C('ZKKEY') . $this->hqversion);
//        exit(execRequest($this->hqurl, $post, 0));
    }
}