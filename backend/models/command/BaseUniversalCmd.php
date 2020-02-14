<?php


namespace backend\models\command;

/**
 * Class BaseUniversalCmd 单区服GM命令接口，直接将客户端的GM命令发送到游戏服务器
 * @package backend\models\command
 */
class BaseUniversalCmd extends BaseSingleServerCmd
{
    public $cmd="";
    public function rules()
    {
        $rule=[
            [['cmd'],'required'],
            [['cmd'],'string','max'=>255],
        ];
        return array_merge(parent::rules(),$rule);
    }
    public function buildCommand()
    {
        if ($this->cmd!="")
        {
            $this->command=$this->cmd;
        }
    }
}