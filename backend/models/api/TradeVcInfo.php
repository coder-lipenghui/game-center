<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-24
 * Time: 10:47
 */

namespace backend\models\api;

use Yii;
class TradeVcInfo extends BaseApiModel
{
    public $logtime;
    public $tradeG;
    public $seedfrom;
    public $tradeM;
    public $seedto;

    public $vcoin;        //表单参数
    public $playerName="";//表单参数
    public $targetName="";//表单参数
    public function rules()
    {
        $parentRules= parent::rules();

        $myRules=[
            [['playerName'],'validateFun','when'=>function($model){return empty($model->playerName);}],
            [['targetName'],'validateFun','when'=>function($model){return empty($model->targetName);}],
            [['vcoin'],'integer','integerOnly' => true, 'min'=>1]
        ];
        return array_merge($parentRules,$myRules);
    }
    public function validateFun($attributeNames = null, $clearErrors = true)
    {
        if(empty($this->playerName)&&empty($this->targetName)&&empty($this->mIndentID)&&empty($this->mTypeID))
        {
            return false;
        }else{
            return true;
        }
    }

    public function attributeLabels()
    {
        $parentLabels=parent::attributeLabels();
        $myLabels=[
            'logtime'       => Yii::t('app', '交易时间'),
            'tradeG'        => Yii::t('app', '发起人'),
            'seedfrom'      => Yii::t('app', '发起人ID'),
            'tradeM'        => Yii::t('app', '接受人'),
            'seedto'        => Yii::t('app', '接受人ID'),
            'vcoin'         => Yii::t('app', '元宝数量'),
        ];
        return array_merge($parentLabels,$myLabels);
    }
}