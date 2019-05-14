<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-26
 * Time: 16:38
 */

namespace backend\models;


class TabItemdefAjax extends TabItemdef
{
    public $gameid=1;
    public function rules()
    {
        $myRules=[
            [['gameid'],'required'],
            [['gameid'],'integer'],
            [['gameid'],'exist','targetClass'=>TabPermission::className(),'targetAttribute'=>['gameid'=>'gid']]
        ];

        return $myRules;
    }
    public function getAllItems()
    {
        return $this->find()->select(['id','name'])->asArray()->all();;
    }
}