<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-18
 * Time: 11:22
 */

namespace backend\models;

use common\helps\CurlHttpClient;
use common\helps\LoggerHelper;
use yii\helpers\ArrayHelper;

class MyTabOrders extends TabOrders
{
    public static function todayAmount()
    {
        $cond=['between','payTime',strtotime(date('Y-m-d')." 00:00:00"),strtotime(date('Y-m-d')."23:59:59")];

        $query=TabOrders::find()
            ->where($cond)
            ->andWhere(['=','payStatus','1'])
            ->select(['payAmount'])->asArray();

        $totalToday=$query->sum('payAmount');

        $totalToday=$totalToday?$totalToday/100:0;

        return $totalToday;
    }
    public static function currentMonthAmount()
    {
        $beginDate=date('Y-m-01',strtotime(date("Y-m-d")));
        $endDate=date('Y-m-d', strtotime("$beginDate +1 month -1 day"));

        $cond=['between','payTime',strtotime($beginDate),strtotime($endDate)];

        $query=TabOrders::find()
            ->where($cond)
            ->andWhere(['=','payStatus','1'])
            ->select(['payAmount'])->asArray();

        $totalToday=$query->sum('payAmount');
        $totalToday=$totalToday?$totalToday/100:0;

        return $totalToday;
    }
    public static function amountGroupByDistributor()
    {
        $beginDate=date('Y-m-01',strtotime(date("Y-m-d")));
        $endDate=date('Y-m-d', strtotime("$beginDate +1 month -1 day"));
        $cond=['between','payTime',strtotime($beginDate),strtotime($endDate)];

        $query=TabOrders::find()
            ->select(['value'=>'sum(payAmount)/100','distributorId'])
            ->join('LEFT JOIN','tab_distribution','tab_orders.distributionId=tab_distribution.id')
            ->where($cond)
            ->asArray()
            ->andWhere(['=','payStatus','1'])
            ->groupBy(['distributorId']);

        $data=$query->all();


        for ($i=0;$i<count($data);$i++)
        {
            $distributor=TabDistributor::find()->where(['id'=>(int)$data[$i]['distributorId']])->one();
            if ($distributor)
            {
                $data[$i]['name']=$distributor->name;
                unset($data[$i]['distributorId']);
            }
        }
        return $data;
    }
    public static function deliver($orderId,$distribution)
    {
        $order=null;
        if($distribution->isDebug || $distribution->isDebug==1)
        {
            $order=TabOrdersDebug::find()->where(['orderId'=>$orderId])->one();
        }else{
            $order=TabOrders::find()->where(['orderId'=>$orderId])->one();
        }
        if ($order===null)
        {
            $msg="订单不存在";
            \Yii::error($msg." orderId:".$orderId,"order");
            return false;
        }
        if ($order->payStatus>0)
        {
            $server=TabServers::find()->where(['id'=>$order->gameServerId])->one();
            if ($server===null)
            {
                $msg="区服不存在";
                LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$order->getFirstError());
                return false;
            }
            $distribution=TabDistribution::find()->where(['id'=>$order->distributionId])->one();
            if ($distribution===null)
            {
                $msg="渠道不存在";
                LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$order->getFirstError());
                return false;
            }
            $requestBody=[
                'channelId'=>$distribution->id,
                'paytouser'=>$order->gameAccount,
                'paynum'=>$order->orderId,
                'paygold'=>$order->payAmount/100*$distribution->ratio,//发放元宝数量= 分/100*比例
                'paymoney'=>$order->payAmount/100,
                'flags'=>1,// 1：充值发放 其他：非充值发放
                'paytime'=>$order->payTime,
                'serverid'=>$order->gameServerId,
            ];
            $game=TabGames::find()->where(['id'=>$server->gameId])->one();
            if($game)
            {
                $paymentKey=$game->paymentKey;

                $requestBody['flag'] = md5($requestBody['paynum'] . urlencode($requestBody['paytouser']) . $requestBody['paygold'] . $requestBody['paytime'] . $paymentKey);

                $url="http://".$server->url."/app/ckcharge.php?".http_build_query($requestBody);

                $curl=new CurlHttpClient();
                $resultJson=$curl->fetchUrl($url);
                $result=json_decode($resultJson,true);
                $msg="";
                switch ($result['code'])
                {
                    case 1:  //发货成功
                    case -5: //订单重复
                        $order->delivered='1';//发货状态：0：未发货 1：已发货
                        if(!$order->save())
                        {
                            $msg="更新订单发货状态失败";
                            LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$order->getErrors());
                            return false;
                        }
                        return true;
                        break;
                    case -1: //防沉迷数据库连接失败
                        $msg="防沉迷数据库连接失败";
                        break;
                    case -2: //账号未找到
                        $msg="[".$requestBody['paytouser']."]账号未找到";
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
                LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$resultJson);
            }else{
                $msg="游戏不存在";
                LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$game->getFirstError());
            }
        }else{
            $msg="订单未支付成功";
            LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$order->getFirstError());
        }
        return false;
    }
}