<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-25
 * Time: 10:56
 */

namespace backend\models\command;


class CmdKick extends BaseCmd
{
    public $name="kick";
    public $playerName="141";
    public $secretKey="oncientwebonline12345678901234567890";

    public $ip="s1001.dzy.7you.xyz";
    public $port="8313";

    public $local_ip="169.254.78.164";
    public $local_port="8306";
    public $local_secretKey="oncientwebonline12345678901234567890";
    public function rules()
    {
        $parentRules=parent::rules();
        $myRules=[
            [['playerName'],'required'],
        ];
        return array_merge($parentRules,$myRules);
    }
    public function attributeLabels()
    {
        $parentLabels=parent::attributeLabels();
        $myLabels=[
            'playerName'=>'玩家名称'
        ];
        return array_merge($parentLabels,$myLabels);
    }

    /**
     * 构建命令
     */
    public function buildCommand()
    {
        $cmd=array_merge([$this->name],[$this->playerName]);
        $this->command=join(" ",$cmd);
    }
    public function buildServers()
    {
        $debug=false;
        $this->serverList=[
            [
                "id"=>4,
                "name"=>"单职业测试",
                "ip"=>$debug?$this->local_ip:$this->ip,
                "port"=>$debug?$this->local_port:$this->port,
                "secretKey"=>$debug?$this->local_secretKey:$this->secretKey,
            ]
        ];
    }
}