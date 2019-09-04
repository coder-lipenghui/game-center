<?php


namespace backend\models\analyze;

use backend\models\MyTabOrders;
use backend\models\MyTabPermission;
use backend\models\MyTabPlayers;
use backend\models\report\ModelLoginLog;
use yii\base\Model;

class ModelDashBoard extends Model
{
    /**
     *
     * @return int
     */
    public function arpuByDay()
    {
        //公式：今日充值金额/今日登录用户数
        $uid=\Yii::$app->user->id;
        $permission=new MyTabPermission();
        $loginNumber=0;
        $amount=0;
        $distributions=$permission->getDistributionByUid($uid);
        if ($distributions)
        {
            for ($i=0;$i<count($distributions);$i++)
            {
                $gameId=$distributions[$i]['gameId'];
                $distributionId=$distributions[$i]['distributionId'];
                ModelLoginLog::TabSuffix($gameId,$distributionId);
                $login=new ModelLoginLog();
                $loginNumber=$loginNumber+$login->loginNumberByDay();
                $orderAmount=MyTabOrders::todayAmountByDistribution($gameId,$distributionId);
                if ($orderAmount && $orderAmount['amount'])
                {
                    $amount=$amount+(float)($orderAmount['amount']);
                }
            }
        }
        if ($loginNumber==0)
        {
            return 0;
        }else{
            return (int)($amount/$loginNumber);
        }
    }

    /**
     * 获取今日的ARPPU
     * @return int
     */
    public function arppuByDay()
    {
        //公式:今日充值金额/今日充值用户数
        $amount=MyTabOrders::todayAmount();
        $payingUser=MyTabOrders::todayPayingUser();
        if ($payingUser==0)
        {
            return 0;
        }else{
            return (int)($amount/$payingUser);
        }
    }
    /**
     * 月arpu
     */
    public  function arpuByMonth($month=null)
    {
        if (!$month)
        {
            $month=date('Y-m');
        }
        //
    }

    /**
     * 月arppu
     */
    public  function arppuByMon()
    {

    }
}