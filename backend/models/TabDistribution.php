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
 * @property int $mingleDistributionId 与某个渠道混服
 * @property int $mingleServerId 从多少区开始混服
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
 * @property int $versionCode 版本ID
 * @property string $versionName 版本Name
 * @property string $packageName 包ID
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
            [['gameId', 'distributorId', 'parentDT', 'mingleDistributionId', 'mingleServerId', 'support', 'ratio', 'rebate', 'enabled', 'isDebug', 'versionCode'], 'integer'],
            [['platform'], 'string', 'max' => 50],
            [['centerLoginKey', 'centerPaymentKey'], 'string', 'max' => 32],
            [['appID', 'appKey', 'appLoginKey', 'appPaymentKey', 'appPublicKey', 'versionName', 'packageName'], 'string', 'max' => 255],
            [['api'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gameId' => Yii::t('app', 'Game ID'),
            'platform' => Yii::t('app', 'Platform'),
            'distributorId' => Yii::t('app', 'Distributor ID'),
            'parentDT' => Yii::t('app', 'Parent Dt'),
            'mingleDistributionId' => Yii::t('app', 'Mingle Distribution ID'),
            'mingleServerId' => Yii::t('app', 'Mingle Server ID'),
            'centerLoginKey' => Yii::t('app', 'Center Login Key'),
            'centerPaymentKey' => Yii::t('app', 'Center Payment Key'),
            'appID' => Yii::t('app', 'App ID'),
            'appKey' => Yii::t('app', 'App Key'),
            'appLoginKey' => Yii::t('app', 'App Login Key'),
            'appPaymentKey' => Yii::t('app', 'App Payment Key'),
            'appPublicKey' => Yii::t('app', 'App Public Key'),
            'support' => Yii::t('app', 'Support'),
            'ratio' => Yii::t('app', 'Ratio'),
            'rebate' => Yii::t('app', 'Rebate'),
            'enabled' => Yii::t('app', 'Enabled'),
            'isDebug' => Yii::t('app', 'Is Debug'),
            'api' => Yii::t('app', 'Api'),
            'versionCode' => Yii::t('app', 'Version Code'),
            'versionName' => Yii::t('app', 'Version Name'),
            'packageName' => Yii::t('app', 'Package Name'),
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
