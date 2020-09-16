<?php


namespace backend\models;

use common\helps\CurlHttpClient;
use common\helps\LoggerHelper;
use backend\events\PreTestEvent;
use yii\db\Exception;

class MyTabOrdersPretest extends TabOrdersPretest
{
    public static function deliver($event)
    {
        $query=self::find()->where(['distributionUserId'=>$event->distributionUserId,'distributionId'=>$event->distributionId,'got'=>0]);
        $rebate=$query->one();
        if (empty($rebate))
        {
            return null;
        }

        $server=TabServers::find()->where(['id'=>$event->serverId])->one();
        $game = TabGames::find()->where(['id' => $event->gameId])->one();
        if ($game && $server) {
            $requestBody = [
                'channelId' => $event->distributionId,
                'paytouser' => $event->account,
                'roleid'    => $event->roleId,
                'paynum'    => 'pt_'.$event->distributionUserId,
                'payscript' => '',
                'paygold'   => $rebate->total*($rebate->rate/100),
                'paymoney'  => $rebate->total/100*($rebate->rate/100),
                'flags'     => 1,// 1：充值发放 其他：非充值发放
                'paytime'   => time(),
                'serverid'  => $event->serverId,
                'type'      => 1, // 1 普通充值，2 脚本触发类型
                'port'      => $server->masterPort
            ];
            $paymentKey = $game->paymentKey;
            $requestBody['flag'] = md5($requestBody['type'] . $requestBody['payscript'] . $requestBody['paynum'] . $requestBody['roleid'] . urlencode($requestBody['paytouser']) . $requestBody['paygold'] . $requestBody['paytime'] . $paymentKey);
            $curl = new CurlHttpClient();
            $url="http://" . $server->url;
            $resultJson = [];
            if (true)//新后台的发货接口
            {
                $getBody=[
                    'sku'=>$game->sku,
                    'did'=>$server->distributorId,
                    'serverId'=>$server->index,
                    'db'=>$requestBody['type']==1?2:1 //脚本类型的需要走octgame,常规类型走ocenter
                ];
                $url = $url. "/api/payment?" . http_build_query($getBody);
                $resultJson =$curl->sendPostData($url,$requestBody);
            }else{
                $url = $url. "/app/ckcharge.php?" . http_build_query($requestBody);
                $resultJson = $curl->fetchUrl($url);
            }
            $result = json_decode($resultJson, true);
            $msg = "";
            switch ($result['code']) {
                case 1:  //发货成功
                case -5: //订单重复
                        $msg = "删档测试订单返利已发放";
                        try {
                            $rebate->got=1;
                            $rebate->rcvServerId=$event->serverId;
                            $rebate->rcvRoleId=$event->roleId;
                            $rebate->rcvRoleName=$event->roleName;
                            $rebate->rcvTime=time();
                            $rebate->save();
                        }catch (\yii\base\Exception $exception)
                        {

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
        } else {
            $msg = "游戏不存在";
        }
    }
}