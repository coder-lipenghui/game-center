<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-10
 * Time: 18:31
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
    public static  function getUserTotal()
    {
        $distributions=self::getDistributions();
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
    public static function getDeviceTotal()
    {
        $distributions=self::getDistributions();
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
     * 今日注册账户数
     * @return int|string
     */
    public static function getTodayRegister()
    {
        $query=self::find()
            ->where(['like','regTime',date('Y-m-d')]);
        $data=$query->count();

        return $data;
    }

    /**
     * 昨日注册账户数
     * @return int|string
     */
    public static function getYesterdayRegister()
    {
        $query=self::find()
            ->where(['like','regTime',date('Y-m-d',strtotime(date('Y-m-d'))-86400000)]);
        $data=$query->count();

        return $data;
    }

    /**
     * 今日注册设备数
     * @return int|string
     */
    public static function getTodayRegisterDevice()
    {
        $query=self::find()
            ->where(['like','regtime',date('Y-m-d')])
            ->groupBy('regdeviceid');

        $data=$query->count();
        return $data;
    }

    /**
     * 昨日注册设备数
     * @return int|string
     */
    public static function getYesterdayRegisterDevice()
    {
        $query=self::find()
            ->where(['like','regtime',date('Y-m-d',strtotime(date('Y-m-d'))-86400000)])
            ->groupBy('regdeviceid');
        $data=$query->count();
        return $data;
    }

    public static function getLast30RegUser()
    {
        $start=date('Y-m-d',strtotime('-30 day'));
        $end=date('Y-m-d');
        return self::getRegUserNumByDate($start,$end);
    }
    public static function getLast30RegDevice()
    {
        $start=date('Y-m-d',strtotime('-30 day'));
        $end=date('Y-m-d');

        return self::getRegDeviceByDate($start,$end);
    }
    /**
     * 获取统计时间内的每日注册用户数
     * @param $day 统计天数
     * @return \yii\db\DataReader
     * @throws \yii\db\Exception
     */
    private static function getRegUserNumByDate($start,$end)
    {
        $sql="SELECT t2.DAY_SHORT_DESC as time,if(t1.number is NULL,0,t1.number) as number FROM 
            (SELECT DAY_SHORT_DESC FROM calendar WHERE DAY_SHORT_DESC>='$start' AND DAY_SHORT_DESC<='$end') as t2 
            LEFT JOIN 
            (SELECT COUNT(account) as number, DATE_FORMAT(regtime,'%Y-%m-%d') as `time` FROM tab_players WHERE regtime>='$start 00:00:00' AND regtime <='$end 59:59:59' GROUP BY time) as t1 
            on t2.DAY_SHORT_DESC=t1.time
            ORDER BY t2.DAY_SHORT_DESC";

        $data=Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
    /**
     * 获取统计时间内的每日注册设备数
     * @param $day 统计天数
     * @return \yii\db\DataReader
     * @throws \yii\db\Exception
     */
    private static function getRegDeviceByDate($start,$end)
    {
        $sql="SELECT t2.DAY_SHORT_DESC as time,if(t1.number is NULL,0,t1.number) as number FROM 
            (SELECT DAY_SHORT_DESC FROM calendar WHERE DAY_SHORT_DESC>='$start' AND DAY_SHORT_DESC<='$end') as t2 
            LEFT JOIN 
            (SELECT COUNT(regdeviceId) as number, DATE_FORMAT(regtime,'%Y-%m-%d') as `time` FROM tab_players WHERE regtime>='$start 00:00:00' AND regtime <='$end 59:59:59' GROUP BY time) as t1 
            on t2.DAY_SHORT_DESC=t1.time
            ORDER BY t2.DAY_SHORT_DESC";

        $data=Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
    public static function getRegNumByMon()
    {

    }

    /**
     * 获取权限内的渠道列表
     * 返回：1,2,3 | null
     * @return string|null
     */
    private static function getDistributions()
    {
        $distributions=null;
        $uid=\Yii::$app->user->id;
        $number=0;
        $modelPermission=new MyTabPermission();
        $permissions=$modelPermission->getDistributionByUid($uid);
        if ($permissions) {
            $distributions = ArrayHelper::getColumn($permissions, 'distributionId');
        }
        return $distributions;
    }
}