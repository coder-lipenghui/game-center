<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-25
 * Time: 10:56
 */

namespace backend\models\command;


class CmdKick extends BaseSingleServerCmd
{
    public $name="kick";
    public $playerName;

    public function rules()
    {
        $parentRules=parent::rules();
        $myRules=[
            [['playerName'],'required'],
        ];
        return array_merge($parentRules,$myRules);
    }

    public function buildCommand()
    {
        $cmd=array_merge([$this->name],[$this->playerName]);
        $this->command=join(" ",$cmd);
    }
}