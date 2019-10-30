<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-14
 * Time: 09:44
 */

namespace backend\models;

use backend\models\command\CmdKick;
use backend\models\command\CmdMail;
use common\helps\CurlHelper;
use common\helps\CurlHttpClient;

class TabSupportCreate extends TabSupport
{
    public function rules()
    {
        return [
            [['gameId','distributorId','serverId','type','number'],'required'],
            [['sponsor', 'gameId', 'distributorId', 'serverId', 'type', 'number', 'status', 'verifier'], 'integer'],
            [['gameId', 'distributorId', 'serverId','reason', 'type', 'number'], 'required'],
            [['roleAccount', 'reason','roleName'], 'string', 'max' => 255],

            ['roleAccount', 'required', 'when' => function($model) {
                return $model->type == 1;
            }],
            ['roleName', 'required', 'when' => function($model) {
                return $model->type == 0;
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
            return $this->save();
        }
        return false;
    }

    public function allow($id)
    {
        $query=self::find();
        $support=$query->where(['id'=>$id])->one();//,'status'=>0,'deliver'=>0
        //权限检测
        if ($support)
        {
            $permission=TabPermission::find()->where(['uid'=>\Yii::$app->user->id,'gameId'=>$support->gameId,'distributorId'=>$support->distributorId,'support'=>1])->one();
            if ($permission)
            {
                $support->verifier=\Yii::$app->user->id;
                $support->status=1;//同意
                if($support->save())
                {
                    if ($support->type==1)
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
                    }else{
                        //普通的走邮件
                        $cmdMail=new CmdMail();
                        $cmdMail->playerName=$support->roleName;
                        $cmdMail->title="金钻发放";
                        $cmdMail->content="[$support->number]金钻已到账，祝您游戏愉快。";
                        $cmdMail->gameId=$support->gameId;
                        $cmdMail->distributorId=$support->distributorId;
                        $cmdMail->serverId=$support->serverId;
                        $cmdMail->items="19008,".$support->number.",0";
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
                $support->save();
            }
        }
    }
    private function deliver($support)
    {
        $requestBody=[
            'channelId'=>$support->distributorId,
            'paytouser'=>$support->roleAccount,
            'paynum'=>time(),
            'paygold'=>$support->number,
            'paymoney'=>$support->number/100,
            'flags'=>1,// 1：充值发放 其他：非充值发放
            'paytime'=>time(),
            'serverid'=>$support->serverId,
        ];
        $game=TabGames::find()->where(['id'=>$support->gameId])->one();
        if($game)
        {
            $server=TabServers::find()->where(['id'=>$support->serverId])->one();
            if ($server)
            {
                $paymentKey=$game->paymentKey;

                $requestBody['flag'] = md5($requestBody['paynum'] . urlencode($requestBody['paytouser']) . $requestBody['paygold'] . $requestBody['paytime'] . $paymentKey);

                $url="http://".$server->url."/app/ckcharge.php?".http_build_query($requestBody);

                $curl=new CurlHttpClient();
                $resultJson=$curl->fetchUrl($url);
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
                }
            }else{
                $msg="区服不存在";
            }
        }
        return false;
    }
}
