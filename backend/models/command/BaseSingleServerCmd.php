<?php


namespace backend\models\command;


use backend\models\TabDebugServers;
use backend\models\TabServers;
use yii\helpers\ArrayHelper;

class BaseSingleServerCmd extends BaseCmd
{
    public $gameId;
    public $serverId;
    public function rules()
    {
        $parentRules= parent::rules();
        $myRules=[
            [['serverId','gameId'],'required'],
            [['gameId','serverId'],'integer']
        ];
        return array_merge($parentRules,$myRules);
    }
    public function buildServers()
    {
        $key="longcitywebonline12345678901234567890";
        $model=TabServers::find();
        if ($this->serverId<15)
        {
            $model=TabDebugServers::find();
        }
        $serverQuery=$model->select(['id','name','port'=>'masterPort','ip'=>'url'])
            ->where(['id'=>$this->serverId]);
        $this->serverList=$serverQuery->asArray()->all();
        $serverData=ArrayHelper::map($serverQuery->all(),'id','name');
        for ($i=0;$i<count($this->serverList);$i++)
        {
            $this->serverList[$i]['name']=$serverData[$this->serverList[$i]['id']];
            $this->serverList[$i]['secretKey']=$key;
        }
    }
}