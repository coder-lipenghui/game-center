<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_distribution".
 *
 * @property int $id
 * @property int $gameId 游戏id
 * @property string $platform 设备:android、ios
 * @property int $distributorId 分销商ID
 * @property int $parentDT 父级代理,该字段有值则代表该渠道为二级分销商
 * @property string $centerLoginKey 中控登录KEY
 * @property string $centerPaymentKey 中控获取订单KEY
 * @property string $appID 分销商分配的游戏ID
 * @property string $appKey 分销商分配的游戏KEY
 * @property string $appLoginKey 分销商分配的登录KEY
 * @property string $appPaymentKey 分销商提供的充值KEY
 * @property string $appPublicKey RSA等key
 * @property int $support 扶持金额数量
 * @property int $ratio 充值获取元宝比例 默认1:100
 * @property int $rebate 好友返利比例，为0则不开启
 * @property int $enabled 该分销渠道是否启用
 * @property int $isDebug 是否已经上线
 * @property string $api 登录、充值验证接口
 *
 * @property TabGameAssets[] $tabGameAssets
 */
class TabDistribution extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_distribution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributorId', 'enabled'], 'required'],
            [['gameId', 'distributorId', 'parentDT', 'support', 'ratio', 'rebate', 'enabled', 'isDebug'], 'integer'],
            [['platform'], 'string', 'max' => 50],
            [['centerLoginKey', 'centerPaymentKey'], 'string', 'max' => 32],
            [['appID', 'appKey', 'appLoginKey', 'appPaymentKey', 'appPublicKey'], 'string', 'max' => 255],
            [['api'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return[
            'id' => Yii::t('app', '分销ID'),
           'gameId' => Yii::t('app', '游戏名称'),
           'platform' => Yii::t('app', '设备平台'),
           'distributorId' => Yii::t('app', '所属分销商'),
           'parentDT' => Yii::t('app', '父级分销商'),
           'centerLoginKey' => Yii::t('app', '我方登录KEY'),
           'centerPaymentKey' => Yii::t('app', '我方订单KEY'),
           'appID' => Yii::t('app', '分销APPID'),
           'appKey' => Yii::t('app', '分销APPKEY'),
           'appLoginKey' => Yii::t('app', '分销登录KEY'),
           'appPaymentKey' => Yii::t('app', '分销充值KEY'),
           'appPublicKey' => Yii::t('app', '分销充值KEY2'),
           'ratio'=>Yii::t('app','充值比例'),
           'rebate'=>Yii::t('app','好友返利比例'),
           'support'=>Yii::t('app','扶持金额'),
           'enabled' => Yii::t('app', '是否可用'),
           'isDebug' => Yii::t('app', '正在调试'),
           'api' => Yii::t('app', 'SDK名'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabGameAssets()
    {
        return $this->hasMany(TabGameAssets::className(), ['distributionId' => 'id']);
    }
}
