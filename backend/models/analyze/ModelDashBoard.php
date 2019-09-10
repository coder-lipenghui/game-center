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
    public function getTodayArpu()
    {
        //公式：今日充值金额/今日登录用户数
        $loginNumber=0;
        $amount=0;
        $distributions=$this->getDistributions();
        if ($distributions)
        {
            for ($i=0;$i<count($distributions);$i++)
            {
                $gameId=$distributions[$i]['gameId'];
                $distributionId=$distributions[$i]['distributionId'];
                ModelLoginLog::TabSuffix($gameId,$distributionId);
                $login=new ModelLoginLog();
                $loginNumber=$loginNumber+$login->getTodayLoginUserNumber();
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
    public function getTodayArppu()
    {
        //公式:今日充值金额/今日充值用户数
        $amount=MyTabOrders::getTodayAmount();
        $payingUser=MyTabOrders::getTodayPayingUser();
        if ($payingUser==0)
        {
            return 0;
        }else{
            return (int)($amount/$payingUser);
        }
    }
    public function getTodayLoginUserNumber()
    {
        $number=0;
        $distributions=$this->getDistributions();
        if ($distributions)
        {
            for ($i=0;$i<count($distributions);$i++)
            {
                $gameId=$distributions[$i]['gameId'];
                $distributionId=$distributions[$i]['distributionId'];
                ModelLoginLog::TabSuffix($gameId,$distributionId);
                $model=new ModelLoginLog();
                $number+=$model->getTodayLoginUserNumber();
            }
        }
        return $number;
    }
    public function getLast30dayLoginUserNumber()
    {
        $number=0;
        $distributions=$this->getDistributions();
        if ($distributions)
        {
            for ($i=0;$i<count($distributions);$i++)
            {
                $gameId=$distributions[$i]['gameId'];
                $distributionId=$distributions[$i]['distributionId'];
                ModelLoginLog::TabSuffix($gameId,$distributionId);
                $model=new ModelLoginLog();
                $number+=$model->getLast30LoginUserNumber();
            }
        }
        return $number;
    }
    public function getLast7dayLoginUserNumber()
    {
        $number=0;
        $distributions=$this->getDistributions();
        if ($distributions)
        {
            for ($i=0;$i<count($distributions);$i++)
            {
                $gameId=$distributions[$i]['gameId'];
                $distributionId=$distributions[$i]['distributionId'];
                ModelLoginLog::TabSuffix($gameId,$distributionId);
                $model=new ModelLoginLog();
                $number+=$model->getLast7LoginUserNumber();
            }
        }
        return $number;
    }
    public function getLast30dayLoginDeviceNumber()
    {
        $number=0;
        $distributions=$this->getDistributions();
        if ($distributions)
        {
            for ($i=0;$i<count($distributions);$i++)
            {
                $gameId=$distributions[$i]['gameId'];
                $distributionId=$distributions[$i]['distributionId'];
                ModelLoginLog::TabSuffix($gameId,$distributionId);
                $model=new ModelLoginLog();
                $number+=$model->getLast30LoginDeviceNumber();
            }
        }
        return $number;
    }
    public function getLast7dayLoginDeviceNumber()
    {
        $number=0;
        $distributions=$this->getDistributions();
        if ($distributions)
        {
            for ($i=0;$i<count($distributions);$i++)
            {
                $gameId=$distributions[$i]['gameId'];
                $distributionId=$distributions[$i]['distributionId'];
                ModelLoginLog::TabSuffix($gameId,$distributionId);
                $model=new ModelLoginLog();
                $number+=$model->getLast7LoginDeviceNumber();
            }
        }
        return $number;
    }
    private function getDistributions()
    {
        $uid = \Yii::$app->user->id;
        $permission = new MyTabPermission();
        $distributions = $permission->getDistributionByUid($uid);
        if ($distributions)
        {
            return $distributions;
        }
        return null;
    }
}