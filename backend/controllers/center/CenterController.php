<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-07
 * Time: 22:04
 */

namespace backend\controllers\center;

use backend\models\center\EnterGame;
use backend\models\center\Login;
use backend\models\MyTabNotice;
use backend\models\MyTabServers;
use backend\models\TabDistribution;
use backend\models\TabDists;
use backend\models\TabGames;
use backend\models\TabNoticeSearch;
use backend\models\TabPlayers;
use yii\web\Controller;

/**
 * 渠道登录、充值相关
 * 登录：
 *      1.参数验证->渠道登录接口验证->我方创建/拉去用户->黑名单->构建游戏返回值：用户、公告、区服。
 *      2.notify->游戏侧API验证
 * 充值：
 *      渠道订单验证->更新支付状态->记录到已支付表->发货
 * @package backend\controllers\center
 */
class CenterController extends Controller
{
    public static $ERROR_SYSTEM                 = -1;
    public static $ERROR_PARAMS                 = -2;
    public static $ERROR_GAME_NOT_FOUND         = -3;
    public static $ERROR_DISTRIBUTOR_NOT_FOUND  = -4;
    public static $ERROR_USER_VALIDATE_FAILED   = -5;
    public static $ERROR_ORDER_VALIDATE_FAILED  = -6;
    public static $ERROR_USER_SAVE_FAILED       = -7;

    public $enableCsrfValidation=false; //允许post访问
    /**
     * 供SDK调用的登录验证接口
     */
    public function actionLogin()
    {
        $data=[];
        //TODO 基本的参数验证
        $loginModel=new Login();
        $jsonData=file_get_contents("php://input");
        $requestData=json_decode($jsonData,true);
        $loginModel->load(['Login'=>$requestData]);
        if ($loginModel->validate())
        {
            //TODO cache检测token，如果有token 则直接跳过验证 直接拉取信息
            $game=TabGames::findOne(['sku'=>$loginModel->sku]);
            if ($game===null)
            {
                $this->send(CenterController::$ERROR_GAME_NOT_FOUND,\Yii::t('app',"未知游戏"));
            }
            $distribution=TabDistribution::findOne(['id'=>$loginModel->dist,'gameId'=>$game->id]);
            if ($distribution===null)
            {
                $this->send(CenterController::$ERROR_DISTRIBUTOR_NOT_FOUND,\Yii::t('app',"分销渠道不存在"));
            }
            $cache=\Yii::$app->cache;
//            $cache->flush();//清理缓存
//            $cache->delete($tokenKey);//根据key清理缓存
            $tokenKey=md5($requestData['uid'].$requestData['dist'].$this->getClientIP());

            $token=$cache->get($tokenKey);
            if(empty($token) || $token===null)
            {
                $user=$this->loginValidate($requestData,$distribution);
                if (empty($user) || $user===null)
                {
                    $this->send(CenterController::$ERROR_USER_VALIDATE_FAILED,\Yii::t('app',"用户验证失败"));
                }
                $player=$this->savePlayer($user,$requestData,$distribution);
                if($player===null)
                {
                    $this->send(CenterController::$ERROR_USER_SAVE_FAILED,\Yii::t('app',"用户信息存储失败"));
                }
                $cache->set($tokenKey,
                    [
                        'distributionId'=>$user['distributionId'],
                        'account'=>$player->account
                    ],
                    10);
                $data['player']=[
                    'token'=>$tokenKey,
                    'uid'=>$player->distributionUserId
                ];
            }else{
                $data['player']=[
                    'token'=>$tokenKey,
                    'uid'=>$token['distributionUserId']
                ];
            }
            //TODO 构建公告信息 ###title|||content###title|||content
            $notice=MyTabNotice::searchGameNotice($game->id,$distribution->id);
            if (count($notice)==0)//默认构建一条公告
            {
                $notice="欢迎|||亲爱的玩家您好，欢迎来到<".$game->name.">。如果您在游戏内遇到问题，请先联系我们的客服 我们将尽快为您解决问题。";
            }
            $servers=MyTabServers::searchGameServers($game->id,$distribution->id);

            $data['serverInfo']=$servers;
            $data['anncInfo']=$notice;
        }else{
            print_r($loginModel->getErrors());
            $this->send(CenterController::$ERROR_PARAMS,\Yii::t('app',"参数错误"));
        }
        $this->send(1,'success',$data);
    }
    public function actionCreateOrder()
    {

    }
    /**
     * 供分销商调用的支付回调接口
     */
    public function actionPaymentCallBack()
    {

    }

    public function actionGetUpdateInfo()
    {
//        $data = array();
//        $list_update=M('updates')->field('gameId,platformid,url,version,filename,SVN_version')->order('tab_updates.platformid')->select();
//        $list_game=M('games')->field('id,name')->order('id')->select();
//        $list_dist=M('dists')->field('gameId,name,distributor,platform')->order('distributor')->select();
//        if ($list_update) {
//            $data['info'] = $list_update;
//        }
//        if ($list_game) {
//            $data['games']=$list_game;
//        }
//        if ($list_dist) {
//            $data['dists']=$list_dist;
//        }
//        exit(json_encode($data));
    }

    /**
     * 前往游戏服务器验证用户信息
     * @param uid 用户ID
     * @param gameid 游戏ID
     * @param pid 平台ID
     * @param sid 区服ID
     */
    public function actionNotifyLogin()
    {
        // 下发参数： uid,token token=md5(uid.)
        //TODO 检测用户、获取游戏url、前往验证
        //参数:
        $enterModle=new EnterGame();
        $request=\Yii::$app->request;
        $enterModle->load($request->queryParams);
        if ($enterModle->validate())
        {
            $this->send(CenterController::$ERROR_PARAMS,\Yii::t('app','参数错误'));
        }

    }

    /**
     * 登录验证，需要在派生类中实现
     * @param $request 请求参数
     * @param $distribution 分销渠道
     * @return player对象|null
     */
    protected function loginValidate($request,$distribution)
    {
        //成功后返回一个player对象
        return null;
    }

    /**
     * 生成中控订单，客户端如果需要使用渠道侧的订单发起充值
     * 则需要在派生类中重写该方法
     */
    protected function createOrder()
    {
        return null;
    }

    /**
     * 支付回调验证，需要在派生类中实现
     */
    protected function orderValidate($request,$distributor)
    {
        return false;
    }

    private function saveOrder()
    {
        return false;
    }
    private function savePlayer($user,$request,$distribution)
    {
        $did=$distribution->id;
//        TODO 新的dist表中需要增加一个互通ID 用于处理安卓跟IOS的账号数据互通
//        if($distributor->intercommunicate)
//        {
//            $did=$distributor->intercommunicate;
//        }
        $uid=md5($distribution->gameId.$user['distributionUserId'].$did);
        $player=TabPlayers::findOne(['account'=>$uid]);
        if ($player===null)
        {
            //TODO 需要支持分表 增加登录验证速度
            $player=new TabPlayers();
            $player->distributionId=$distribution->id;
            $player->gameId=$distribution->gameId;
            $player->distributionUserId=$user['distributionUserId'];
            $player->distributionUserAccount=$user['distributionUserAccount'];
            $player->account=$uid;
            $player->regdeviceId=$request['deviceId'];
            $player->regtime=date('Y-m-d H:i:s',time());
            $player->regip=$_SERVER["REMOTE_ADDR"];
//            $player->timestamp=date('Y-m-d H:i:s',time());
            if($player->save())
            {
                return $player;
            }else{
                return null;
            }
        }
        return null;
    }

    /**
     * 发货
     */
    protected function deliver()
    {
        //TODO 访问游戏侧API接口
        //TODO 按照渠道的充值比例进行发货，游戏记录的金额为分，默认1：100的比例。
    }

    /**
     * 响应客户端请求
     * @param array $data
     */
    private function send($code,$message,$data=[])
    {
        $responseData=['code'=>$code,'message'=>$message,'data'=>$data];
        $response = \Yii::$app->response;
//        $response->isSent=true;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data=$responseData;
        $response->send();
        exit();
    }
    /**
     * 获取客户端IP
     * @param int $type
     * @param bool $adv 是否开启高级模式
     * @return mixed
     */
    private function getClientIP($type = 0,$adv=false)
    {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}