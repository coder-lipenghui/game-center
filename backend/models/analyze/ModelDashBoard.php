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
//    public function getTodayArpu($gameId)
//    {
//        //公式：今日充值金额/今日登录用户数
//        $loginNumber=0;
//        $amount=0;
//        $distributions=$this->getDistributions($gameId);
//        if ($distributions)
//        {
//            for ($i=0;$i<count($distributions);$i++)
//            {
//                $gameId=$distributions[$i]['gameId'];
//                $distributionId=$distributions[$i]['distributionId'];
//                ModelLoginLog::TabSuffix($gameId,$distributionId);
//                $login=new ModelLoginLog();
//                $loginNumber=$loginNumber+$login->getTodayLoginUserNumber();
//                $orderAmount=MyTabOrders::todayAmountByDistribution($gameId,$distributionId);
//                if ($orderAmount && $orderAmount['amount'])
//                {
//                    $amount=$amount+(float)($orderAmount['amount']);
//                }
//            }
//        }
//        if ($loginNumber==0)
//        {
//            return 0;
//        }else{
//            return (int)($amount/$loginNumber);
//        }
//    }

    /**
     * 获取今日的ARPPU
     * @return int
     */
    public function getTodayArppu($gameId)
    {
        //公式:今日充值金额/今日充值用户数
        $amount=MyTabOrders::getTodayRevenue($gameId);
        $payingUser=MyTabOrders::getTodayPayingUser($gameId);
        if ($payingUser==0)
        {
            return 0;
        }else{
            return (int)($amount/$payingUser);
        }
    }
    public function getTodayLoginUserNumber($gameId)
    {
        $number=0;
        $distributors=$this->getDistributors($gameId);
        if ($distributors)
        {
            for ($i=0;$i<count($distributors);$i++)
            {
                $gameId=$distributors[$i]['gameId'];
                $distributorId=$distributors[$i]['distributorId'];
                ModelLoginLog::TabSuffix($gameId,$distributorId);
                $model=new ModelLoginLog();
                $number+=$model->getTodayLoginUserNumber();
            }
        }
        return $number;
    }
    public function getLast30dayLoginUserNumber($gameId)
    {
        $number=0;
        $distributors=$this->getDistributors($gameId);
        if ($distributors)
        {
            for ($i=0;$i<count($distributors);$i++)
            {
                $gameId=$distributors[$i]['gameId'];
                $distributorId=$distributors[$i]['distributorId'];
                ModelLoginLog::TabSuffix($gameId,$distributorId);
                $model=new ModelLoginLog();
                $number+=$model->getLast30LoginUserNumber();
            }
        }
        return $number;
    }
    public function getLast7dayLoginUserNumber($gameId)
    {
        $number=0;
        $distributors=$this->getDistributors($gameId);
        if ($distributors)
        {
            for ($i=0;$i<count($distributors);$i++)
            {
                $gameId=$distributors[$i]['gameId'];
                $distributorId=$distributors[$i]['distributorId'];
                $model=new ModelLoginLog();
                $model::TabSuffix($gameId,$distributorId);
                $number+=$model->getLast7LoginUserNumber();
            }
        }
        return $number;
    }
    public function getLast30dayLoginDeviceNumber($gameId)
    {
        $number=0;
        $distributors=$this->getDistributors();
        if ($distributors)
            for ($i=0;$i<count($distributors);$i++)
        {
            for ($i=0;$i<count($distributors);$i++)
            {
                $gameId=$distributors[$i]['gameId'];
                $distributorId=$distributors[$i]['distributorId'];
                ModelLoginLog::TabSuffix($gameId,$distributorId);
                $model=new ModelLoginLog();
                $number+=$model->getLast30LoginDeviceNumber();
            }
        }
        return $number;
    }
    public function getLast7dayLoginDeviceNumber($gameId)
    {
        $number=0;
        $distributors=$this->getDistributors($gameId);
        if ($distributors)
        {
            for ($i=0;$i<count($distributors);$i++)
            {
                $gameId=$distributors[$i]['gameId'];
                $distributorId=$distributors[$i]['distributorId'];
                ModelLoginLog::TabSuffix($gameId,$distributorId);
                $model=new ModelLoginLog();
                $number+=$model->getLast7LoginDeviceNumber();
            }
        }
        return $number;
    }
    public function Last7dayLoginDeviceGroupByDay($gameId)
    {

    }
    private function getDistributors($gameId)
    {
        $uid = \Yii::$app->user->id;
        $permission = new MyTabPermission();
        $distributors = $permission->getDistributorByUidAndGameId($uid,$gameId);
        if ($distributors)
        {
            return $distributors;
        }
        return null;
    }
    private function getDistributions($gameId)
    {
        $uid = \Yii::$app->user->id;
        $permission = new MyTabPermission();
        $distributors = $permission->getDistributionByUidAndGameId($uid,$gameId);
        if ($distributors)
        {
            return $distributors;
        }
        return null;
    }
}