<?php


namespace backend\models;


use common\helps\CurlHttpClient;
use common\helps\LoggerHelper;

class MyTabRebate extends TabOrdersRebate
{
    public function addRebateByOrder($order,$ratio)
    {
        if ($order && $order->payStatus==1)
        {
            $contact=new MyTabContact();
            $contact::TabSuffix($order->gameId,$order->distributorId);
            $contactQuery=$contact::find()->where(['activeRoleId'=>$order->gameRoleId]);
            $target=$contactQuery->one();
            if (!empty($target))
            {
                $rebateOrder=TabOrdersRebate::find()->where(['distributionOrderId'=>$order->distributionOrderId])->one();
                if (!empty($rebateOrder))
                {
                    if ($rebateOrder->delivered>0)
                    {
                        $msg = "该笔订单已发过返利";
                        LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg, '');
                        return false;
                    }else{
                        if(self::deliver($rebateOrder->orderId))
                        {
                            
                        }
                    }
                }else{
                    $account=TabPlayers::find()->where(['account'=>$target->passivityAccount])->one();
                    if ($account)
                    {
                        $orderId=substr(md5($order->orderId.time()),8,16);

//                  绑定好友的信息
                        $this->gameAccount=$target->passivityAccount;
                        $this->gameRoleId=$target->passivityRoleId;
                        $this->productName="好友充值返利";

                        $this->orderId=$orderId; //需要重新生成一个ID
//              原来的订单信息
                        $this->distributionUserId=$account->distributionUserId;
                        $this->gameId=$order->gameId;
                        $this->distributorId=$order->distributorId;
                        $this->distributionId=$order->distributionId;
                        $this->distributionOrderId=$order->distributionOrderId;
                        $this->gameServerId=$order->gameServerId;
                        $this->payAmount=$order->payAmount*($ratio/100);
                        $this->payTime=$order->payTime;
                        $this->gameServername=$order->gameServername;
                        $this->createTime=time();
                        $this->payStatus='1';
                        if ($this->save())
                        {
                            self::deliver($orderId);
                        }else{
                            $msg = "返利订单创建失败";
                            LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg,$this->getErrors());
                            return false;
                        }
                    }else{
                        $msg = "关联账号不存在";
                        LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg,$this->getErrors());
                        return false;
                    }
                }
            }else{
                $msg = "未关联好友";
                LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg, $contactQuery->createCommand()->getRawSql());
                return false;
            }
        }else{
            $msg = "该笔订单未完成支付";
            LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg, '');
            return false;
        }
    }
    public static function deliver($orderId)
    {
        $order=MyTabRebate::find()->where(['orderId'=>$orderId])->one();
        if ($order===null)
        {
            $msg="订单不存在";
            \Yii::error($msg." orderId:".$orderId,"order");
            return false;
        }
        if ($order->delivered>0)
        {
            $msg="该笔订单已发货";
            LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg,"");
        }else {
            if ($order->payStatus > 0) {
                $server = TabServers::find()->where(['id' => $order->gameServerId])->one();
                if ($server === null) {
                    $msg = "区服不存在";
                    LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg, $server->getFirstError());
                    return false;
                }
                $distribution = TabDistribution::find()->where(['id' => $order->distributionId])->one();
                if ($distribution === null) {
                    $msg = "渠道不存在";
                    LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg, $distribution->getFirstError());
                    return false;
                }
                $requestBody = [
                    'channelId' => $distribution->id,
                    'paytouser' => $order->gameAccount,
                    'roleid' => $order->gameRoleId,
                    'paynum' => $order->orderId,
                    'payscript' => '',
                    'paygold' => $order->payAmount / 100 * $distribution->ratio,//发放元宝数量= 分/100*比例
                    'paymoney' => $order->payAmount / 100,
                    'flags' => 1,// 1：充值发放 其他：非充值发放
                    'paytime' => $order->payTime,
                    'serverid' => $order->gameServerId,
                    'type' => 1, // 1 普通充值，2 脚本触发类型
                ];
                $game = TabGames::find()->where(['id' => $server->gameId])->one();
                if ($game) {
                    $paymentKey = $game->paymentKey;

                    $requestBody['flag'] = md5($requestBody['type'] . $requestBody['payscript'] . $requestBody['paynum'] . $requestBody['roleid'] . urlencode($requestBody['paytouser']) . $requestBody['paygold'] . $requestBody['paytime'] . $paymentKey);

                    $url = "http://" . $server->url . "/app/ckcharge.php?" . http_build_query($requestBody);

                    $curl = new CurlHttpClient();
                    $resultJson = $curl->fetchUrl($url);
                    $result = json_decode($resultJson, true);
                    $msg = "";
                    switch ($result['code']) {
                        case 1:  //发货成功
                        case -5: //订单重复
                            $order->delivered = '1';//发货状态：0：未发货 1：已发货
                            if (!$order->save()) {
                                $msg = "更新订单发货状态失败";
                                LoggerHelper::OrderError($order->gameId, $order->distributionId, $msg, $order->getErrors());
                                return false;
                            }
                            return true;
                            break;
                        case -1: //防沉迷数据库连接失败
                            $msg = "防沉迷数据库连接失败";
                            break;
                        case -2: //账号未找到
                            $msg = "[" . $requestBody['paytouser'] . "]账号未找到";
                            break;
                        case -3: //IP限制，暂时废弃
                            $msg = "IP限制";
                            break;
                        case -4: //sign验证出错
                            $msg = "sign验证出错";
                            break;
                        case -6: //超时，暂时废弃
                            $msg = "超时";
                            break;
                        case -8: //发货参数不全
                            $msg = "发货参数不全";
                            break;
                        case -9: //发货数与金额比例不正确，服务器侧写死了【paymoney*100=paygold】
                            $msg = "发货数与金额比例不正确";
                            break;
                    }
                    LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg, $resultJson);
                } else {
                    $msg = "游戏不存在";
                    LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg, '');
                }
            } else {
                $msg = "订单未支付成功";
                LoggerHelper::RebateError($order->gameId, $order->distributionId, $msg,'');
            }
        }
        return false;
    }
}