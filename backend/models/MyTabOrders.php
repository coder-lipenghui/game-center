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
    /**
     * 今日付费玩家数量
     * @return int
     */
    public static function todayPayingUser()
    {
        $uid=\Yii::$app->user->id;
        $number=0;
        $modelPermission=new MyTabPermission();
        $permissions=$modelPermission->getDistributionByUid($uid);

        if ($permissions)
        {
            for ($i=0;$i<count($permissions);$i++)
            {
                $gameId=$permissions[$i]['gameId'];
                $distributionId=$permissions[$i]['distributionId'];

                $query=TabOrders::find();
                $query->where([
                        'gameId'=>$gameId,
                        'distributionId'=>$distributionId,
                        "FROM_UNIXTIME(payTime,'%Y-%m-%d')"=>date('Y-m-d'),
                        'payStatus'=>'1',
                        ])
                      ->groupBy('gameAccount');
                $number=$number+(int)$query->count();
            }
        }
        return $number;
    }
    /**
     * 今日充值总金额
     * @return float|int|mixed
     */
    public static function todayAmount()
    {
        $uid=\Yii::$app->user->id;
        $amount=0;
        $modelPermission=new MyTabPermission();
        $permissions=$modelPermission->getDistributionByUid($uid);

        if ($permissions)//统计用户权限内的渠道充值金额
        {
            for ($i=0;$i<count($permissions);$i++) {
                $gameId = $permissions[$i]['gameId'];
                $distributionId = $permissions[$i]['distributionId'];
                $query=TabOrders::find()
                    ->where(['payStatus'=>'1','FROM_UNIXTIME(payTime,"%Y-%m-%d")'=>date('Y-m-d'),'gameId'=>$gameId,'distributionId'=>$distributionId])
                    ->select(['payAmount'])->asArray();
                $totalToday=$query->sum('payAmount');
                $totalToday=$totalToday?$totalToday/100:0;
                $amount=$amount+$totalToday;
            }
        }
        return $amount;
    }

    /**
     * 昨日充值金额
     * @return float|int|mixed
     */
    public static function yesterdayAmount()
    {
        //TODO 需要根据用户权限进行各项统计
        $cond=['between','payTime',strtotime(date('Y-m-d')." 00:00:00")-86400000,strtotime(date('Y-m-d')."23:59:59")-86400000];

        $query=TabOrders::find()
            ->where($cond)
            ->andWhere(['=','payStatus','1'])
            ->select(['payAmount'])->asArray();

        $totalYesterday=$query->sum('payAmount');

        $totalYesterday=$totalYesterday?$totalYesterday/100:0;

        return $totalYesterday;
    }

    /**
     * 过去30天内每天的充值金额
     */
    public static function getLast30Amount()
    {
        $start=date('Y-m-d',strtotime('-30 day'));
        $end=date('Y-m-d');
        return self::getAmountGroupByDay($start,$end);
    }

    /**
     * 过去30天内每天的充值人数
     * @throws \yii\db\Exception
     */
    public static function getLast30PayingUser()
    {
        $start=date('Y-m-d',strtotime('-30 day'));
        $end=date('Y-m-d');
        self::getPayingUserGroupByDay($start,$end);
    }
    /**
     * 获取起止日期内每日充值金额
     * @param $start
     * @param $end
     * @return array
     * @throws \yii\db\Exception
     */
    private static function getAmountGroupByDay($start,$end)
    {
        //测试SQL:
        //SELECT t1.time,if(t2.amount is NULL,0,t2.amount) FROM (SELECT DAY_SHORT_DESC as time FROM calendar WHERE DAY_SHORT_DESC>='2019-08-01' AND DAY_SHORT_DESC<='2019-09-01') as t1 LEFT JOIN (SELECT SUM(payAmount/100) as amount,FROM_UNIXTIME(payTime,'%Y-%m-%d') as time FROM tab_orders WHERE distributionId in (1,5,7) and payStatus='1' AND FROM_UNIXTIME(payTime,'%Y-%m-%d')>='2019-08-01' and FROM_UNIXTIME(payTime,'%Y-%m-%d')<='2019-09-01' GROUP BY FROM_UNIXTIME(payTime,'%Y-%m-%d')) as t2 ON t1.time=t2.time ORDER BY t1.time;
        $uid=\Yii::$app->user->id;
        $modelPermission=new MyTabPermission();
        $permissions=$modelPermission->getDistributionByUid($uid);
        $distributionsArr=ArrayHelper::getColumn($permissions,'distributionId');
        $distributions=join(",",$distributionsArr);
        $sql="SELECT t1.time,if(t2.amount is NULL,0,t2.amount) as amount FROM 
            (SELECT DAY_SHORT_DESC as time FROM calendar WHERE DAY_SHORT_DESC>='$start' AND DAY_SHORT_DESC<='$end') as t1 
            LEFT JOIN 
            (SELECT SUM(payAmount/100) as amount,FROM_UNIXTIME(payTime,'%Y-%m-%d') as time FROM tab_orders WHERE distributionId in ($distributions) and payStatus='1' AND FROM_UNIXTIME(payTime,'%Y-%m-%d')>='$start' and FROM_UNIXTIME(payTime,'%Y-%m-%d')<='$end' GROUP BY FROM_UNIXTIME(payTime,'%Y-%m-%d')) as t2 
            ON t1.time=t2.time 
            ORDER BY t1.time";
        $data=$query=\Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }

    /**
     * 获取起止日期内每日充值人数
     * @param $start
     * @param $end
     * @return array
     * @throws \yii\db\Exception
     */
    private static function getPayingUserGroupByDay($start,$end)
    {
        //测试SQL：
        //SELECT t1.time,if(t2.number is NULL,0,t2.number) FROM (SELECT DAY_SHORT_DESC as time FROM calendar WHERE DAY_SHORT_DESC>='2019-08-01' AND DAY_SHORT_DESC<='2019-09-01') as t1 LEFT JOIN (SELECT COUNT(*) as number,FROM_UNIXTIME(payTime,'%Y-%m-%d') as time FROM tab_orders WHERE distributionId in (1,5,7) and payStatus='1' AND FROM_UNIXTIME(payTime,'%Y-%m-%d')>='2019-08-01' and FROM_UNIXTIME(payTime,'%Y-%m-%d')<='2019-09-01' GROUP BY gameAccount) as t2 ON t1.time=t2.time ORDER BY t1.time;
        $uid=\Yii::$app->user->id;
        $modelPermission=new MyTabPermission();
        $permissions=$modelPermission->getDistributionByUid($uid);
        $distributionsArr=ArrayHelper::getColumn($permissions,'distributionId');
        $distributions=join(",",$distributionsArr);
        $sql="SELECT t1.time,if(t2.number is NULL,0,t2.number) as number FROM 
            (SELECT DAY_SHORT_DESC as time FROM calendar WHERE DAY_SHORT_DESC>='$start' AND DAY_SHORT_DESC<='$end') as t1 
            LEFT JOIN 
            (SELECT count(*) as number,FROM_UNIXTIME(payTime,'%Y-%m-%d') as time FROM tab_orders WHERE distributionId in ($distributions) and payStatus='1' AND FROM_UNIXTIME(payTime,'%Y-%m-%d')>='$start' and FROM_UNIXTIME(payTime,'%Y-%m-%d')<='$end' GROUP BY gameAccount) as t2 
            ON t1.time=t2.time 
            ORDER BY t1.time";
        $data=$query=\Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
    /**
     * 本月充值金额
     * @return float|int|mixed
     */
    public static function currentMonthAmount()
    {
        //TODO 需要根据用户权限进行各项统计
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

    /**
     * 获取某个渠道的今日充值金额
     * @param $gameId
     * @param $distributionId
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function todayAmountByDistribution($gameId,$distributionId)
    {
        //TODO 需要根据用户权限进行各项统计
        $date=date('Y-m-d');
        $query=MyTabOrders::find();
        $query->select(['amount'=>'sum(payAmount/100)'])
              ->where(['gameId'=>$gameId,'distributionId'=>$distributionId,'payStatus'=>'1',"FROM_UNIXTIME(payTime,'%Y-%m-%d')"=>$date])
              ->asArray();
        return $query->one();
    }

    /**
     * 本月各分销商充值金额
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function amountGroupByDistributor()
    {
        //TODO 需要根据用户权限进行各项统计
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

    /**
     * 发货接口
     * @param $orderId
     * @param $distribution
     * @return bool
     */
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