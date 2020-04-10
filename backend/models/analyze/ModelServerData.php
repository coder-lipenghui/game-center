<?php


namespace backend\models\analyze;


use backend\models\report\ModelLoginLog;
use backend\models\report\ModelRoleLog;
use backend\models\report\TabLogRole;
use backend\models\TabServers;
use yii\base\Model;

class ModelServerData extends Model
{
    public $gameId;
    public $distributorId;
    public $serverId;
    public $startDate;
    public $type; //1 最近开区 2 单区 3单区按日期及天数
    public $day;
    public $num;
    private static $TYPE_LATEST=1;
    private static $TYPE_SINGLE_DATE=2;
    private static $TYPE_SINGLE_DAYS=3;
    public function rules()
    {
        return [
            [['gameId','distributorId','type'],'required'],
            [['startDate','serverId'],'required','when'=>function($model) {
                return $model->type == 2 || $model->type==3;
            }],
            [['num'],'required','when'=>function($model) {
                return $model->type == 1;
            }],
            [['day'],'required','when'=>function($model) {
                return $model->type == 3;
            }],
            [['startDate'],'string','max'=>100],
            [['gameId','distributorId','day','type'],'integer'],
        ];
    }

    /**
     * 获取留存数据
     * 主入口，根据分类返回留存数据
     * @return array|null
     * @throws \yii\base\InvalidConfigException
     */
    public function getRetain()
    {
        $request=\Yii::$app->request->getQueryParams();
//        return $request;
        $params=['ModelServerData'=>$request];
        $this->load($params);
        $result=['code'=>-1,'msg'=>'','data'=>[]];
        if($this->validate())
        {
            $result['code']=1;
            $result['msg']="success";
            if ($this->type==self::$TYPE_LATEST)
            {
                $result['data']=$this->topServerByOpenTime($this->num);
            }
            if ($this->type==self::$TYPE_SINGLE_DATE)
            {
                $result['data']=$this->getRetainData($this->serverId,strtotime($this->startDate));
            }
            if($this->type==self::$TYPE_SINGLE_DAYS)
            {
                $result['data']=$this->signServerDays($this->serverId,strtotime($this->startDate),$this->day);
            }
            return $result;
        }else{
            $result['msg']="参数错误";
            $result['data']=$this->getErrors();
        }
        return $result;
    }

    /**
     * 最新开区的留存数据
     * @param $limit
     * @return array
     */
    private function topServerByOpenTime($limit)
    {
        $servers=TabServers::find()->select(['id','index','openDateTime'])->where(['gameId'=>$this->gameId,'distributorId'=>$this->distributorId])->orderBy('openDateTime DESC')->limit($limit)->asArray()->all();
        $result=[];
        for ($i=0;$i<count($servers);$i++)
        {
            $result[]=['index'=>$servers[$i]['index'],'value'=>$this->getRetainData($servers[$i]['id'],strtotime($servers[$i]['openDateTime']))];
        }
        return $result;
    }
    /**
     * 查看单个区连续N个自然日的留存情况
     * @param $sid 区ID
     * @param $date 开始时间
     * @param $day 天数
     * @return array [[总人数、次留、3留、5留、7留、15留、30留]]
     */
    private function signServerDays($sid,$date,$day)
    {
        $result=[];
        for ($i=0;$i<$day;$i++)
        {
            $tmp=$date+($i*24*60*60);
            array_push($result,["index"=>date('Y-m-d',$tmp),"value"=>$this->getRetainData($sid,$tmp)]);
        }
        return $result;
    }
    /**
     * @param $date 时间戳时间
     * @param $sid 区服ID
     * @return array [总人数、次留、3留、5留、7留、15留、30留]
     */
    private function getRetainData($sid,$date)
    {
        //预期返回的数据 总人数、次留、3留、5留、7留、15留、30留
        $comparedDay=[1,2,4,6,14,29];
        $comparedDate=[];//日期
        $comparedData=[0,0,0,0,0,0,0];//数据

        $createTime=date("Y-m-d",$date);
        //默认30天
        //根据时间获取新进账号
        //TODO 这个地方目前是角色创建时间而非账号创建时间，需要改成账号创建时间
        $roleData=new ModelRoleLog();
        $roleData::TabSuffix($this->gameId,$this->distributorId);
        $roleQuery=$roleData::find()->select(['account'])->where(["FROM_UNIXTIME(createTime,'%Y-%m-%d')"=>$createTime,'serverId'=>$sid])->groupBy('account');
        $roleResult=$roleQuery->asArray()->all();
        //获取账号前往登录日志表筛选
        if (!empty($roleResult))
        {
            $comparedData[0]=count($roleResult);
            for ($i=0;$i<count($comparedDay);$i++)
            {
                $tmpDate=date("Y-m-d", strtotime("$createTime +$comparedDay[$i] day"));
                array_push($comparedDate,$tmpDate);
            }
            for ($i=0;$i<count($comparedDay);$i++)
            {
                $loginData=new ModelLoginLog();
                $loginData::TabSuffix($this->gameId,$this->distributorId);
                $loginQuery=$loginData::find()->select(['account'])->where(["FROM_UNIXTIME(logTime,'%Y-%m-%d')"=>$comparedDate[$i],'serverId'=>$sid])->groupBy("account");
                $loginResult=$loginQuery->asArray()->all();
                $num=0;
                $roles=array_column($roleResult,"account");
                //TODO 找一种更高效的对比方查找方式
                foreach ($roles as $v)
                {
                    if (array_search($v,array_column($loginResult,"account")))
                    {
                        $num++;
                    }
                }
                $comparedData[$i+1]=$num;
            }
        }
        return $comparedData;
    }
}