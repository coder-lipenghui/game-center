<?php


namespace backend\models\report;


use backend\models\TabPlayers;
use backend\models\TabServers;

class ModelStartLog extends TabLogStart
{
    protected static $gameId;
    protected static $distributionId;

    public static function TabSuffix($gid,$did)
    {
        self::$gameId=$gid;
        self::$distributionId=$did;
    }
    public function rules()
    {
        return parent::rules();
    }
    public static function tableName()
    {
        $originalName=parent::tableName();
        if (self::$gameId && self::$distributionId)
        {
            return $originalName.'_'.self::$gameId.'_'.self::$distributionId;
        }
        return $originalName;
    }
    public function doRecord($params)
    {
        $result=['code'=>-1,'msg'=>'参数错误','data'=>[]];
        $this->logTime=time();
        $this->ip=\Yii::$app->request->getUserIP();
        $this->load(['ModelStartLog'=>$params]);
        if($this->validate())
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
            $result['data']=$this->getErrors();
        }
        return $result;
    }
}