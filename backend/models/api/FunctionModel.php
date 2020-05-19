<?php


namespace backend\models\api;


use Yii;

class FunctionModel extends BaseApiModel
{
    public $type;
    public $subtype;
    public $newLv;

    public function rules()
    {
        $rules=parent::rules();
        $myRules=[
            [['type','subtype','newLv'],'integer']
        ];

        return array_merge($rules,$myRules);
    }
    public function attributeLabels()
    {
        $parentLabels=parent::attributeLabels();
        $myLabels=[
            'type' => Yii::t('app', '系统名称'),
            'subtype' => Yii::t('app', '系统子类'),
            'newLv' => Yii::t('app', '等级'),
        ];
        return array_merge($parentLabels,$myLabels);
    }
}