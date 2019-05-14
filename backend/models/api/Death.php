<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-23
 * Time: 17:09
 */

namespace backend\models\api;

use Yii;

class Death extends BaseApiModel
{
    public $src;
    public $logtime;
    public $mapid;
    public $killname;
    public $x;
    public $y;

    public function rules()
    {
        $rules=parent::rules();
        $myRules=[
            [['playerName'],'required'],
        ];
        return array_merge($rules,$myRules);
    }
    public function attributeLabels()
    {
        $parentLabels=parent::attributeLabels();
        $myLabels=[
            'chrname'=>Yii::t('app', '玩家名称'),
            'logtime' => Yii::t('app', '记录时间'),
            'mapid' => Yii::t('app', '死亡地图'),
            'killname' => Yii::t('app', '击杀人/怪'),
            'x' => Yii::t('app', '死亡坐标X'),
            'y' => Yii::t('app', '死亡坐标Y'),
            ];
        return array_merge($parentLabels,$myLabels);
    }
}