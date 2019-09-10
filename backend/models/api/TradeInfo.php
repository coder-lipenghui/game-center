<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-23
 * Time: 20:40
 */

namespace backend\models\api;

use Yii;
class TradeInfo extends BaseApiModel
{
    public $logtime;
    public $tradeG;
    public $seedfrom;
    public $tradeM;
    public $seedto;

    public $mPosition;
    public $mDuraMax;
    public $mDuration;
    public $mItemFlags;
    public $mNumber;
    public $mLuck;
    public $mCreatetime;
    public $playerName=""; //表单参数
    public $mIndentID=""; //表单参数
    public $targetName="";//表单参数
    public $mTypeID="";   //表单参数
    public function rules()
    {
        $parentRules= parent::rules();

        $myRules=[
            [['playerName'],'validateFun','when'=>function($model){return empty($model->playerName);}],
            [['mIndentID'],'validateFun','when'=>function($model){return empty($model->mIndentID);}],
            [['targetName'],'validateFun','when'=>function($model){return empty($model->targetName);}],
            [['mTypeID'],'validateFun','when'=>function($model){return empty($model->mTypeID);}],
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
            'mTypeID'       => Yii::t('app', '交易物品'),
            'mPosition'     => Yii::t('app', '位置'),
            'mDuraMax'      => Yii::t('app', '未知参数'),
            'mDuration'     => Yii::t('app', '未知参数'),
            'mItemFlags'    => Yii::t('app', '未知参数'),
            'mNumber'       => Yii::t('app', '交易数量'),
            'mLuck'         => Yii::t('app', '幸运'),
            'mCreatetime'   => Yii::t('app', '物品产出时间'),
            'mIndentID'     => Yii::t('app', '物品唯一ID'),
        ];
        return array_merge($parentLabels,$myLabels);
    }
}