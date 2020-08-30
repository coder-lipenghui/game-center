<?php


namespace backend\models\analyze;

use backend\models\report\ModelRoleLog;
use backend\models\TabGames;
use backend\models\TabOrders;
use backend\models\TabServers;
use common\helps\CurlHttpClient;
use yii\base\Model;

class ModelServerPayData extends Model
{
    public $gameId;
    public $distributorId;
    public $serverId;
    public $sDate;
    public $eDate;
    public $day;
    public $num;

    public $type;

    public function rules()
    {
        return [
            [['gameId','distributorId','type'],'required'],
            [['gameId','distributorId','type','serverId'],'integer']
        ];
    }
    public function getPayData()
    {
//        预期返回数据[总人数，付费人数，付费金额]
        $result=["code"=>-1,"msg"=>"","data"=>[]];
        $request=\Yii::$app->request->getQueryParams();
        $this->load(['ModelServerPayData'=>$request]);
        if ($this->validate()){

            $result['code']=1;
            if ($this->type==1)
            {
                $result['data']=$this->dashboard($this->serverId);
            }
        }
        else{
            $result=["code"=>-2,"msg"=>"参数错误","data"=>[]];
        }
        return $result;
    }
    //概况
    public function dashboard($sid)
    {
        //开服至今的数据
        $query=TabServers::find()->where(['id'=>$sid]);
        $server=$query->one();
        if ($server)
        {
            $st=$server->openDateTime;
            $et=date('Y-m-d',time());

            $roleNum=$this->getRoleNumCount($sid,$st,$et);
            $payRoleNum=$this->getPayRoleCount($sid,$st,$et);
            $payAmount=$this->getPayAmountCount($sid,$st,$et);
            return [$roleNum,$payRoleNum,$payAmount];

        }else{
            exit(json_encode($server->getErrors()));
        }
    }
    //付费人数
    function getPayRoleCount($sid,$s,$e)
    {
        $query=TabOrders::find()->where(['gameId'=>$this->gameId,'distributorId'=>$this->distributorId,'gameServerId'=>$sid,'payStatus'=>'1'])->groupBy('gameAccount');
        $result=$query->count();
        return $result;
    }
    //充值金额
    function getPayAmountCount($sid,$s,$e)
    {
        $query=TabOrders::find()->where(['gameId'=>$this->gameId,'distributorId'=>$this->distributorId,'gameServerId'=>$sid,'payStatus'=>'1']);
        $result=$query->sum('payAmount');
        return $result;
    }
    //区服总人数
    function getRoleNumCount($sid,$s,$e)
    {
        $roleData=new ModelRoleLog();
        $roleData::TabSuffix($this->gameId,$this->distributorId);
        $result=$roleData::find()->where(['serverId'=>$sid])->groupBy('account')->asArray()->count();

        return $result;
    }
    function getPayRoleTotal()
    {

    }

    /**
     * 服务器记录的金钻消耗分布数据
     * @param $sid
     * @param $s
     * @param $e
     * @return |null
     */
    function getConsumeDetail()
    {
        $server=TabServers::find()->where(['id'=>$this->serverId])->one();
        if (!empty($server->mingleServerId))
        {
            $server=TabServers::find()->where(['id'=>$server->mingleServerId])->one();
        }
        if (empty($server))
        {
            return null;
        }
        $game=TabGames::find()->where(['id'=>$server->gameId])->one();
        if (empty($game)) return null;
        $getBody=[
            'sku'=>$game->sku,
            'did'=>$server->distributorId,
            'serverId'=>$server->index,
            'db'=>3
        ];
        $url="http://".$server->url."/api/consume/dashboard?".http_build_query($getBody);
        $curl=new CurlHttpClient();
        $resultJson=$curl->fetchUrl($url);
        return $resultJson;
    }
}