<?php


namespace backend\models\report;


use backend\models\TabPlayers;
use backend\models\TabServers;

class ModelLoginLog extends  TabLogLogin
{
    protected static $gameId;
    protected static $distributorId;

    public static function TabSuffix($gid,$did)
    {
        self::$gameId=$gid;
        self::$distributorId=$did;
    }
    public static function tableName()
    {
        $originalName=parent::tableName();
        if (self::$gameId && self::$distributorId)
        {
            return $originalName.'_'.self::$gameId.'_'.self::$distributorId;
        }
        return $originalName;
    }

    /**
     * 记录数据接口
     * 如果你不确定这个地方是做什么的，请不要乱动。
     * @param $params
     * @return array
     */
    public function doRecord($params)
    {
        $result=['code'=>-1,'msg'=>'参数错误','data'=>[]];
        $this->logTime=time();
        $this->load(['ModelLoginLog'=>$params]);
        $this->roleName=urldecode($this->roleName);
        if($this->validate())
        {
            $player=TabPlayers::find()->where(['distributionUserId'=>$this->distributionUserId])->one();
            if ($player)
            {
                $server=TabServers::find()->where(['id'=>$this->serverId])->one();
                if ($server)
                {
                    if($this->save())
                    {
                        $result['code']=1;
                        $result['msg']="success";
                    }else{
                        $result['code']=-2;
                        $result['msg']="记录失败";
                        $result['data']=$this->getErrors();
                    }
                }else{
                    $result['code']=-3;
                    $result['msg']="区服不存在";
                }
            }else{
                $result['code']=-2;
                $result['msg']="渠道账号不存在";
            }
        }else{
            $result['data']=$this->getErrors();
        }
        return $result;
    }

    public function getLast30LoginUserNumber()
    {
        return $this->getLoginUserNumberByDay(30);
    }
    public function getLast30LoginDeviceNumber()
    {
        return $this->getLoginDeviceNumberByDay(30);
    }

    public function getLast7LoginUserNumber()
    {
        return $this->getLoginUserNumberByDay(7);
    }

    public function getLast7LoginDeviceNumber()
    {
        return $this->getLoginDeviceNumberByDay(7);
    }

    public function getTodayLoginUserNumber()
    {
        return $this->getLoginUserNumberByDay(0);
    }

    public function getTodayLoginDeviceNumber()
    {
        return $this->getLoginDeviceNumberByDay(0);
    }

    /**
     * 获取过去多少天内的登录用户数
     * @param $day
     * @return int|string
     */
    private function getLoginUserNumberByDay($day)
    {
        $start=date('Y-m-d',strtotime("-$day day"));
        $end=date('Y-m-d');
        return $this->getLoginUserNumberByDate($start,$end);
    }

    /**
     * 获取过去多少天内的登录设备数
     * @param $day
     * @return int|string
     */
    private function getLoginDeviceNumberByDay($day)
    {
        $start=date('Y-m-d',strtotime("-$day day"));
        $end=date('Y-m-d');
        return $this->getDeviceNumberByDate($start,$end);
    }

    /**
     * 获取某一时段内的登录账号数量
     *
     * @param $start 开始日期
     * @param $end 结束日期
     * @return int|string
     */
    private function getLoginUserNumberByDate($start,$end)
    {
        //SELECT account,roleName,COUNT(account),FROM_UNIXTIME(logTime) as time FROM tab_log_login_1_7 WHERE FROM_UNIXTIME(logTime,'%Y-%m-%d')='2019-09-04' GROUP BY account
        $query=self::find()
            ->select(['account','roleName','count(account)','FROM_UNIXTIME(logTime)'])
            ->where([">=","FROM_UNIXTIME(logTime,'%Y-%m-%d')",$start])
            ->andWhere(["<=","FROM_UNIXTIME(logTime,'%Y-%m-%d')",$end])
            ->groupBy('account');
        //exit($query->createCommand()->getRawSql());
        $data=$query->count();
        return $data;
    }

    /**
     * 获取某一时段内的登录设备数量
     * @param $start 开始日期
     * @param $end 结束日期
     * @return int|string
     */
    private function getDeviceNumberByDate($start,$end)
    {
        //SELECT account,roleName,COUNT(account),FROM_UNIXTIME(logTime) as time FROM tab_log_login_1_7 WHERE FROM_UNIXTIME(logTime,'%Y-%m-%d')='2019-09-04' GROUP BY account
        $query=self::find()
            ->select(['account','roleName','count(account)','FROM_UNIXTIME(logTime)'])
            ->where([">=","FROM_UNIXTIME(logTime,'%Y-%m-%d')",$start])
            ->andWhere(["<=","FROM_UNIXTIME(logTime,'%Y-%m-%d')",$end])
            ->groupBy('deviceId');
        $data=$query->count();
        return $data;
    }

    private function getDeviceNumberGroupByDate($start,$end)
    {
        $query=self::find();
    }
}