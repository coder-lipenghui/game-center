<?php


namespace backend\models\command;

/**
 * Class CmdDenyCharacter 禁止角色登录
 * @package backend\models\command
 */
class CmdDenyCharacter extends BaseSingleServerCmd
{
    public $name="denychr";
    public $roleName;

    public function rules()
    {
        $parentRules= parent::rules();
        $myRules=[
            [['roleName'],'required'],
            [['roleName'],'string']
        ];
        return array_merge($parentRules,$myRules);
    }

    public function buildCommand()
    {
        $this->command=join(" ",[$this->name,$this->roleName]);
    }
}