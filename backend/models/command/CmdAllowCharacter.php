<?php


namespace backend\models\command;


class CmdAllowCharacter extends BaseSingleServerCmd
{
    public $name="allowchr";
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