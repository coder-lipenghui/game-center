<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-14
 * Time: 09:44
 */

namespace backend\models;

use backend\controllers\LogtypeController;
use backend\models\command\CmdKick;
use backend\models\command\CmdMail;
use common\helps\CurlHelper;
use common\helps\CurlHttpClient;
use common\helps\LoggerHelper;

class TabSupportCreate extends TabSupport
{
    private static $TYPE_SIMULATE_MAIL=0;//不算充值
    private static $TYPE_SIMULATE_NORMAL=1;//算充值 货币
    private static $TYPE_SIMULATE_SCRIPT=2;//算充值 脚本触发类型物品:月卡等
    private static $TYPE_SIMULATE_ITEM=3;//道具物品
    public function rules()
    {
        return [
            [['gameId','distributorId','serverId','type','number','roleName','roleAccount','roleId'],'required'],
            [['sponsor', 'gameId', 'distributorId', 'serverId', 'type', 'number', 'status', 'verifier','productId'], 'integer'],
            [['gameId', 'distributorId', 'serverId','reason', 'type', 'number'], 'required'],
            [['roleAccount','roleName', 'reason','roleId','items'], 'string', 'max' => 255],

            ['productId','required','when'=>function($model){
                return $model->type == self::$TYPE_SIMULATE_SCRIPT;
            }],
            [['items'],'required','when'=>function($model){
                return $model->type == self::$TYPE_SIMULATE_ITEM;
            }],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
            [['roleAccount'],'exist','skipOnError' => false,'targetClass'=>TabPlayers::className(),'targetAttribute'=>['roleAccount'=>'account']]
        ];
    }
    public function create()
    {
        $request=\Yii::$app->request;
        $this->load($request->queryParams);
        if ($this->validate())
        {
            $this->sponsor=\Yii::$app->user->id;
            $this->applyTime=date('Y-m-d H:i:s');
            return $this->save();
        }
        return false;
    }
    public function autoDeliver()
    {
        $bonus=TabBonus::find()->where(['gameId'=>$this->gameId,'distributorId'=>$this->distributorId])->one();
        if ($bonus)
        {
            $bindAmount=$bonus->bindAmount;
            $unbindAmount=$bonus->unbindAmount;

            if ($this->type!=self::$TYPE_SIMULATE_MAIL)//充值类型
            {
                if ($this->number<=$unbindAmount)
                {
                    $bonus->unbindAmount=$unbindAmount-$this->number;
                    if($bonus->save())
                    {
                        $this->allow($this->id);
                        return true;
                    }
                }
            }else//非充值
            {
                if ($this->number<=$bindAmount)
                {
                    $bonus->bindAmount=$bindAmount-$this->number;
                    if($bonus->save())
                    {
                        $this->allow($this->id);
                        return true;
                    }
                }
            }
        }
        return false;
    }
    public function allow($id)
    {
        $query=self::find();
        $support=$query->where(['id'=>$id])->andWhere(['!=','deliver',2])->one();
        if ($support)
        {
            $permission=TabPermission::find()->where(['uid'=>\Yii::$app->user->id,'gameId'=>$support->gameId,'distributorId'=>$support->distributorId,'support'=>1])->one();
            if ($permission)
            {
                $support->verifier=\Yii::$app->user->id;
                $support->status=1;//同意
                $support->consentTime=date('Y-m-d H:i:s');
                if($support->save())
                {
                    if ($support->type==self::$TYPE_SIMULATE_NORMAL || $support->type==self::$TYPE_SIMULATE_SCRIPT)
                    {
                        //充值的走订单
                        if ($this->deliver($support))
                        {
                            $support->deliver=2;//发货成功
                            $support->save();
                            return true;
                        }else{
                            $support->deliver=1;//发货失败
                            $support->save();
                        }
                    }
                    else{
                        //普通的走邮件
                        $cmdMail=new CmdMail();
                        $cmdMail->playerName=$support->roleId;
                        $cmdMail->title=$support->type==self::$TYPE_SIMULATE_ITEM?"道具发放":"金钻发放" ;
                        $cmdMail->type=2;
                        $cmdMail->content=$support->type==self::$TYPE_SIMULATE_ITEM?"请查收":"[$support->number]金钻已到账，祝您游戏愉快。";
                        $cmdMail->gameId=$support->gameId;
                        $cmdMail->distributorId=$support->distributorId;
                        $cmdMail->serverId=$support->serverId;
                        $cmdMail->items=$support->type==self::$TYPE_SIMULATE_ITEM?$support->items:"19008,".$support->number.",0";
                        $cmdMail->buildCommand();
                        $cmdMail->buildServers();
                        $result=$cmdMail->execu();
                        if ($result && $result[0]['code']==1)
                        {
                            $support->deliver=2;//发货成功
                            $support->save();
                            return true;
                        }else{
                            $support->deliver=1;//发货失败
                            $support->save();
                            LoggerHelper::SupportError($support->gameId,$support->distributorId,"[".$support->roleId."]邮件发放失败",$result);
                        }
                    }
                }
            }
        }
        return false;
    }
    public function refuse($id)
    {
        $query=self::find();
        $support=$query->where(['id'=>$id])->one();
        //权限检测
        if ($support)
        {
            $permission=TabPermission::find()->where(['uid'=>\Yii::$app->user->id,'gameId'=>$support->gameId,'distributorId'=>$support->distributorId,'support'=>1])->one();
            if ($permission)
            {
                $support->verifier=\Yii::$app->user->id;
                $support->status=2;//拒绝
                $support->consentTime=date('Y-m-d H:i:s');
                $support->save();
            }
        }
    }
    private function deliver($support)
    {
        $product=null;
        $payScript='';
        $payMoney=$support->number/100;

        $game=TabGames::find()->where(['id'=>$support->gameId])->one();
        if($game)
        {
            if ($support && $support->type==self::$TYPE_SIMULATE_SCRIPT)
            {
                $product=TabProduct::find()->where(['id'=>$support->productId])->one();
                if (empty($product))
                {
                    LoggerHelper::OrderError($game->id, $support->distributorId, "计费商品不存在:".$support->productId, $support);
                    return false;
                }else{
                    $payScript=$product->productScript;
                    $payMoney=$product->productPrice/100;
                }
            }
            $requestBody = [
                'channelId' => $support->distributorId,
                'paytouser' => $support->roleAccount,
                'roleid' => $support->roleId,
                'paynum' => 'FC_'.time(),
                'payscript' => $payScript,
                'paygold' => $support->number,
                'paymoney' => $payMoney,
                'flags' => 1,// 1：充值发放 其他：非充值发放
                'paytime' => time(),
                'serverid' => $support->serverId,
                'type' => $support->type,//1普通 2脚本触发
                'port'=>''
            ];
            $server=null;
            if ($support->serverId<15)
            {
                $server=TabDebugServers::find()->where(['id'=>$support->serverId])->one();
            }else{
                $server=TabServers::find()->where(['id'=>$support->serverId])->one();
            }
            if ($server)
            {
                if (!empty($server->mergeId))
                {
                    $tmp=TabServers::find()->where(['id'=>$server->mergeId])->one();
                    if (!empty($tmp))
                    {
                        $server=$tmp;
                    }
                }
                $paymentKey=$game->paymentKey;
                $requestBody['port']=$server->masterPort;
                $requestBody['flag'] = md5($requestBody['type'] . $requestBody['payscript'] . $requestBody['paynum'] . $requestBody['roleid'] . urlencode($requestBody['paytouser']) . $requestBody['paygold'] . $requestBody['paytime'] . $paymentKey);
                $url="http://".$server->url;
                //$url="http://gameapi.com:8888";
                $curl=new CurlHttpClient();
                $getBody=[
                    'sku'=>$game->sku,
                    'serverId'=>$server->index,
                    'db'=>$requestBody['type']==1?2:1 //脚本类型的需要走octgame,常规类型走ocenter
                ];
                if ($support->serverId<15)
                {
                    $getBody['sku']='TEST';
                    $getBody['did']=$game->versionId;
                }else{
                    $getBody['did']=$server->distributorId;
                }
                $url = $url. "/api/payment?" . http_build_query($getBody);
                $resultJson =$curl->sendPostData($url,$requestBody);
                $result=json_decode($resultJson,true);
                $msg="";
                $code=$result['code'];
                switch ($code)
                {
                    case 1:  //发货成功
                        $msg="success";
                        break;
                    case -5: //订单重复
                        $msg="防沉迷数据库连接失败";
                        break;
                    case -1: //防沉迷数据库连接失败
                        $msg="防沉迷数据库连接失败";
                        break;
                    case -2: //账号未找到
                        $msg="[$support->roleAccount]账号未找到";
                        break;
                    case -3: //IP限制，暂时废弃
                        $msg="IP限制";
                        break;
                    case -4: //sign验证出错
                        $msg="sign验证出错";
                        break;
                    case -6: //超时，暂时废弃
                        $msg="超时";
                        break;
                    case -8: //发货参数不全
                        $msg="发货参数不全";
                        break;
                    case -9: //发货数与金额比例不正确，服务器侧写死了【paymoney*100=paygold】
                        $msg="发货数与金额比例不正确";
                        break;
                }
                if ($code==1 || $code==5)
                {
                    return true;
                }else{
                    LoggerHelper::OrderError($game->id, $support->distributorId, $getBody, $requestBody);
                }
            }else{
                $msg="区服不存在";
                LoggerHelper::OrderError($game->id, $support->distributorId, $msg,$requestBody);
            }
        }else{
            $msg="游戏不存在";
            LoggerHelper::OrderError(0, $support->distributorId, $msg,"TabSupportCreate");
        }
        return false;
    }
}
