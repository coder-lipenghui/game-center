<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-29
 * Time: 11:17
 */

namespace backend\models\center;

use backend\models\AutoCDKEYModel;
use backend\models\command\CmdMail;
use backend\models\TabCdkeyRecord;
use backend\models\TabCdkeyVariety;
use backend\models\TabDebugServers;
use backend\models\TabDistribution;
use backend\models\TabGames;
use backend\models\TabPlayers;
use backend\models\TabServers;
use common\helps\CurlHttpClient;

class ActivateCdkey extends TabCdkeyRecord
{
    public $sku;

    public function rules()
    {
        return [
            [['sku', 'distributionId','serverId', 'account', 'roleId', 'roleName', 'cdkey'], 'required'],
            [['distributionId', 'logTime','serverId','varietyId'], 'integer'],
            [['account', 'roleId', 'roleName', 'cdkey','sku'], 'string', 'max' => 100],
//            [['distributionId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistribution::className(), 'targetAttribute' => ['distributionId' => 'id']],
//            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
//            [['serverId'], 'exist', 'skipOnError' => true, 'targetClass' => TabServers::className(), 'targetAttribute' => ['serverId' => 'id']],
        ];
    }

    public function useCdk()
    {
        $request=\Yii::$app->request;
        $this->load(['ActivateCdkey'=>$request->queryParams]);
        if ($this->validate())
        {
            //游戏检测
            $game=TabGames::find()->where(['sku'=>$this->sku])->one();
            if ($game)
            {
                //渠道检测
                $distribution=TabDistribution::findOne(['id'=>$this->distributionId]);
//                if($distribution){
                //玩家检测
                $player=TabPlayers::find()->where(['account'=>$this->account])->one();
                if ($player)
                {
                    //激活码检测
                    $cdkeyModel=new AutoCDKEYModel();

                    //通用类型激活码检测
                    $query=$cdkeyModel::find()->where(['cdkey'=>$this->cdkey,'gameId'=>$game->id]);
                    $cdkey=$query->one();
                    if (empty($cdkey))
                    {
                        //普通类型激活码
                        $cdkeyModel=new AutoCDKEYModel();
                        $cdkeyModel::TabSuffix($game->id,$distribution->distributorId);
                        $query=$cdkeyModel::find()->where(['cdkey'=>$this->cdkey]);
                        $cdkey=$query->one();
                    }
                    if ($cdkey)
                    {
                        $variety=TabCdkeyVariety::find()->where(['id'=>$cdkey->varietyId])->one();
                        if (empty($variety))
                        {
                            return ['code'=>-3,'msg'=>'未知激活码类型'];
                        }
                        $used=false;
                        //激活码类型限制：角色只能使用一次
                        $used=self::find()->where(['cdkey'=>$this->cdkey,'varietyId'=>$cdkey->varietyId])->one();
                        if (!empty($used) && $variety->type==1)
                        {
                            return ['code'=>-6,'msg'=>'该激活码已使用'];
                        }
                        if (!empty($variety->once))
                        {
                            $once=$this::find()->where(['varietyId'=>$cdkey->varietyId,'roleId'=>$this->roleId])->one();
                            if($once)
                            {
                                return ['code'=>-1,'msg'=>'该类型激活码只能使用一次'];
                            }
                        }
                        //普通类型激活码检测激活码使用状态
                        if ($variety->type==1 && (!empty($cdkey->used) || $cdkey->used==1)) {
                            return ['code'=>-6,'msg'=>'该激活码已使用'];
                        }
                        //记录使用信息
                        $this->setAttribute('gameId',$game->id);
                        $this->setAttribute('logTime',time());
                        $this->varietyId=$cdkey->varietyId;
                        if ($this->save())
                        {
                            //区服
                            $server=null;
                            if($this->serverId<15)
                            {
                                $server=TabDebugServers::findOne(['id'=>$this->serverId]);
                            }else{
                                $server=TabServers::findOne(['id'=>$this->serverId]);
                            }
                            if (!empty($server->mergeId))
                            {
                                $tmp=TabServers::find()->where(['id'=>$server->mergeId])->one();
                                if (!empty($tmp))
                                {
                                    $server=$tmp;
                                }
                            }
                            //发货
                            if ($variety->deliverType==1)
                            {
                                $curl=new CurlHttpClient();
                                $sign=md5($this->roleId.$this->roleName.$this->cdkey.$variety->items.$variety->name.$variety->type.$game->paymentKey);
                                $body=[
                                    'roleId'=>$this->roleId,
                                    'roleName'=>$this->roleName,
                                    'cdkey'=>$this->cdkey,
                                    'type'=>$variety->type,
                                    'variety'=>$variety->name,
                                    'item'=>$variety->items,
                                    'port'=>$server->masterPort,
                                    'sign'=>$sign
                                ];
                                $get=[
                                    'sku'=>$game->sku,
                                    'serverId'=>$server->index,
                                    'db'=>1
                                ];
                                if($this->serverId<15)
                                {
                                    $get['sku']="TEST";
                                    $get['did']=$game->versionId;
                                }else{
                                    $get['did']=$server->distributorId;
                                }
                                $json=null;
                                $url=$server->url;
                                if (true)//新接口
                                {
                                    $url='http://'.$url.'/api/cdkey?'.http_build_query($get);
                                    $json=$curl->sendPostData($url,$body);
                                }else{
                                    $url='http://'.$url.'/app/ckgift.php?';
                                    $json=$curl->fetchUrl($url.http_build_query($body));
                                }
                                if ($curl->getHttpResponseCode()==200)
                                {
                                    $result=json_decode($json,true);
                                    $code=$result['code'];
                                    if ($code==1)
                                    {
                                        //激活码状态更改
                                        $cdkey->setAttribute('used',1);
                                        if($cdkey->save())
                                        {
                                            return ['code'=>1,'msg'=>'激活成功,请打开背包查看'];
                                        }else{
                                            return ['code'=>-7,'msg'=>'激活码状态更新失败'];
                                        }
                                    }else{
                                        //-1：参数错误 -2：连接失败 -3：数据库选取失败 -4：数据写入失败 -5：sign验证失败
                                        \Yii::error($body,'order');
                                        return ['code'=>-10,'msg'=>"激活失败[$code]"];
                                    }
                                }else{
                                    \Yii::error($url.http_build_query($body),'cdkey');
                                    return ['code'=>-9,'msg'=>'激活出现异常'];
                                }
                            }else{
                                 //邮件发放
                                $cmdMail=new CmdMail();
                                $cmdMail->playerName=$this->roleId;
                                $cmdMail->title=$variety->name;
                                $cmdMail->type=2;
                                $cmdMail->content="恭喜获得[".$variety->name."],祝您游戏愉快。";
                                $cmdMail->gameId=$game->id;
                                $cmdMail->distributorId=$distribution->distributorId;
                                $cmdMail->serverId=$server->id;
                                $cmdMail->items=$variety->items;
                                $cmdMail->buildCommand();
                                $cmdMail->buildServers();
                                $result=$cmdMail->execu();
                                if ($result && $result[0]['code']==1)
                                {
                                    //激活码状态更改
                                    $cdkey->setAttribute('used',1);
                                    if($cdkey->save())
                                    {
                                        return ['code'=>1,'msg'=>'激活成功,请打开背包查看'];
                                    }else{
                                        return ['code'=>-11,'msg'=>'激活码状态更新失败'];
                                    }
                                }else{
                                    return ['code'=>-12,'msg'=>"激活失败"];
                                }
                            }
                        }else{
                            return ['code'=>-8,'msg'=>'激活码激活失败'];
                        }
                    }else{
                        return ['code'=>-5,'msg'=>'激活码不存在'];
                    }
                }else{
                    return ['code'=>-4,'msg'=>'玩家不存在'];
                }
            }else{
                return ['code'=>-2,'msg'=>'游戏不存在'];
            }
        }else{
            \Yii::error($this->getErrors(),'ckdey');
            return ['code'=>-1,'msg'=>'参数不正确','data'=>$this->getErrors()];
        }
    }
}