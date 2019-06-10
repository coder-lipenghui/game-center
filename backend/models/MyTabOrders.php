<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-18
 * Time: 11:22
 */

namespace backend\models;


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
            ->select(['value'=>'sum(payAmount)','distributorId'])
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
}