<?php


namespace backend\models\command;


use backend\models\TabGames;
use backend\models\TabServers;
use yii\helpers\ArrayHelper;

class CmdUnvoice extends BaseCmd
{
    public $name="denychr";
    public $roleName="";
    public $time;
    public $gameId;
    public $serverId;
    public function rules()
    {
        $parentRules= parent::rules();
        $myRules=[
            [['roleName','serverId','time','gameId'],'required'],
            [['roleName'],'string'],
            [['time'],'integer','max'=>999999],
            [['gameId','serverId'],'integer']
        ];
        return array_merge($parentRules,$myRules);
    }

    public function buildCommand()
    {
        $this->command=join(" ",[$this->name,$this->roleName,$this->time]);
    }

    public function buildServers()
    {
        //TODO 增加权限校验
        $key="longcitywebonline12345678901234567890";
        $serverQuery=TabServers::find()
            ->select(['id','name','port'=>'masterPort','ip'=>'url'])
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