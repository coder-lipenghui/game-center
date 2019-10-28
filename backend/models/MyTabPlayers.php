<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-10
 * Time: 18:31
 *
 */

namespace backend\models;


use Yii;
use yii\helpers\ArrayHelper;

class MyTabPlayers extends TabPlayers
{
    //TODO 需要按照权限内的渠道来进行统计
    /**
     * 获取总账号数
     * @return int|string
     */
    public static  function getUserTotal($gameId)
    {
        $distributions=self::getDistributions($gameId);
        if ($distributions)
        {
            $query=MyTabPlayers::find();

            $query->select('account')
                ->where(['distributionId'=>$distributions])
                ->groupBy('account');
            $data=$query->count();
            return $data;
        }
        return 0;

    }
    public static function getDeviceTotal($gameId)
    {
        $distributions=self::getDistributions($gameId);
        if ($distributions)
        {
            $query=MyTabPlayers::find();
            $query->select('regdeviceId')
                ->where(['distributionId'=>$distributions])
                ->groupBy('regdeviceId');
            //exit($query->createCommand()->getRawSql());
            $data=$query->count();
            return $data;
        }
        return 0;
    }
    /**
     * 各渠道用户数量
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getNumberGroupByDistributor()
    {
        $query=self::find()
            ->select(['distributorId','value'=>'count(account)'])
            ->join('LEFT JOIN','tab_distribution','tab_players.distributionId=tab_distribution.id')
            ->groupBy(['distributorId'])
            ->asArray();
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
     * 获取各渠道多少天内每天的注册账号数量
     * @param $day
     * @param $gameId
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getRegNumGroupByDistributor($day,$gameId=null)
    {
        $start=date('Y-m-d',strtotime("-$day day"));
        $end=date('Y-m-d');
        return self::getRegGroupByDistributor($start,$end,$gameId);
    }

    /**
     * 获取各分销商某时段内每天的注册账号数量
     * @param $start 开始时间
     * @param $end 结束时间
     * @return array 按照分销商、日期分类的数组
     * @throws \yii\db\Exception
     */
    private static function getRegGroupByDistributor($start,$end,$gameId=null)
    {
        $distributors=self::getDistributors($gameId);
        $data=[];
        if ($distributors)
        {
            foreach ($distributors as $distributor)
            {
                $sql="SELECT t2.DAY_SHORT_DESC as time,if(t1.number is NULL,0,t1.number) as number FROM (SELECT DAY_SHORT_DESC FROM calendar WHERE DAY_SHORT_DESC>='$start' AND DAY_SHORT_DESC<='$end') as t2 LEFT JOIN (SELECT distributorId,COUNT(*) as number, DATE_FORMAT(regtime,'%Y-%m-%d') as `time` FROM tab_players WHERE regtime>='$start 00:00:00' AND regtime <='$end 59:59:59' AND distributorId = $distributor GROUP BY distributorId,time) as t1 on t2.DAY_SHORT_DESC=t1.time ORDER BY t2.DAY_SHORT_DESC";
                $data[$distributor.""] = Yii::$app->db->createCommand($sql)->queryAll();
            }
        }
        return $data;
    }
    /**
     * 今日注册账户数
     * @return int|string
     */
    public static function getTodayRegister($gameId)
    {
        $distributions=self::getDistributions($gameId);
        if ($distributions) {
            $query = self::find()
                ->where(['like', 'regTime', date('Y-m-d')])
                ->andWhere(['distributionId'=>$distributions]);
            $data = $query->count();

            return $data;
        }
        return 0;
    }

    /**
     * 昨日注册账户数
     * @return int|string
     */
    public static function getYesterdayRegister($gameId)
    {
        $distributions=self::getDistributions($gameId);
        if ($distributions)
        {
            $query=self::find()
                ->where(['like','regTime',date('Y-m-d',strtotime(date('Y-m-d'))-86400000)])
                ->andWhere(['distributionId'=>$distributions]);
            $data=$query->count();

            return $data;
        }
        return 0;
    }

    /**
     * 今日注册设备数
     * @return int|string
     */
    public static function getTodayRegisterDevice($gameId)
    {
        $distributions=self::getDistributions($gameId);
        if ($distributions)
        {
            $query=self::find()
                ->where(['like','regtime',date('Y-m-d')])
                ->andWhere(['distributionId'=>$distributions])
                ->groupBy('regdeviceid');

            $data=$query->count();
            return $data;
        }
        return 0;
    }

    /**
     * 昨日注册设备数
     * @return int|string
     */
    public static function getYesterdayRegisterDevice($gameId)
    {
        $query=self::find()
            ->where(['like','regtime',date('Y-m-d',strtotime(date('Y-m-d'))-86400000)])
            ->groupBy('regdeviceid');
        $data=$query->count();
        return $data;
    }

    public static function getLast30RegUser($gameId)
    {
        $start=date('Y-m-d',strtotime('-30 day'));
        $end=date('Y-m-d');
        return self::getRegUserNumByDate($gameId,$start,$end);
    }
    public static function getLast30RegDevice($gameId)
    {
        $start=date('Y-m-d',strtotime('-30 day'));
        $end=date('Y-m-d');

        return self::getRegDeviceByDate($gameId,$start,$end);
    }
    /**
     * 获取统计时间内的每日注册用户数
     * @param $day 统计天数
     * @return \yii\db\DataReader
     * @throws \yii\db\Exception
     */
    private static function getRegUserNumByDate($gameId,$start,$end)
    {
        $distributions=self::getDistributionString($gameId);
        if ($distributions) {
            $sql = "SELECT t2.DAY_SHORT_DESC as time,if(t1.number is NULL,0,t1.number) as number FROM 
                (SELECT DAY_SHORT_DESC FROM calendar WHERE DAY_SHORT_DESC>='$start' AND DAY_SHORT_DESC<='$end') as t2 
                LEFT JOIN 
                (SELECT COUNT(account) as number, DATE_FORMAT(regtime,'%Y-%m-%d') as `time` FROM tab_players WHERE regtime>='$start 00:00:00' AND regtime <='$end 59:59:59' AND distributionId in ($distributions) GROUP BY time) as t1 
                on t2.DAY_SHORT_DESC=t1.time
                ORDER BY t2.DAY_SHORT_DESC";

            $data = Yii::$app->db->createCommand($sql)->queryAll();
            return $data;
        }
        return [];
    }
    /**
     * 获取统计时间内的每日注册设备数
     * @param $day 统计天数
     * @return \yii\db\DataReader
     * @throws \yii\db\Exception
     */
    private static function getRegDeviceByDate($gameId,$start,$end)
    {
        $distributions=self::getDistributionString($gameId);
        if ($distributions)
        {
            $sql="SELECT t2.DAY_SHORT_DESC as time,if(t1.number is NULL,0,t1.number) as number FROM 
            (SELECT DAY_SHORT_DESC FROM calendar WHERE DAY_SHORT_DESC>='$start' AND DAY_SHORT_DESC<='$end') as t2 
            LEFT JOIN 
            (SELECT COUNT(regdeviceId) as number, DATE_FORMAT(regtime,'%Y-%m-%d') as `time` FROM tab_players WHERE regtime>='$start 00:00:00' AND regtime <='$end 59:59:59' AND distributionId in($distributions) GROUP BY time) as t1 
            on t2.DAY_SHORT_DESC=t1.time
            ORDER BY t2.DAY_SHORT_DESC";

            return Yii::$app->db->createCommand($sql)->queryAll();

        }
        return [];
    }
    public static function getRegNumByMon()
    {

    }

    /**
     * 获取权限内的渠道列表
     * 返回：1,2,3 | null
     * @return string|null
     */
    private static function getDistributions($gameId)
    {
        $distributions=null;
        $uid=\Yii::$app->user->id;
        $modelPermission=new MyTabPermission();
        $permissions=$modelPermission->getDistributionByUidAndGameId($uid,$gameId);
        if ($permissions) {
            $distributions = ArrayHelper::getColumn($permissions, 'distributionId');
        }
        return $distributions;
    }
    private static function getDistributionString($gameId)
    {
        $distributions=null;
        $uid=\Yii::$app->user->id;
        $modelPermission=new MyTabPermission();
        $permissions=$modelPermission->getDistributionByUidAndGameId($uid,$gameId);
        if ($permissions)
        {
            $distributionsArr=ArrayHelper::getColumn($permissions,'distributionId');
            $distributions=join(",",$distributionsArr);
        }
        return $distributions;
    }
    private static function getDistributors($gameId=null)
    {
        $distributions=[];
        $uid=\Yii::$app->user->id;
        $modelPermission=new MyTabPermission();
        $permissions=$modelPermission->getDistributorsByUid($uid,$gameId);
        if ($permissions)
        {
            $distributions=ArrayHelper::getColumn($permissions,'distributorId');
//            $distributions=join(",",$distributionsArr);
        }
        return $distributions;
    }
}