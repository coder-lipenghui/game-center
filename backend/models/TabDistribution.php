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
 * @property int $ratio 充值获取元宝比例 默认1:100
 * @property int $enabled 该分销渠道是否启用
 * @property int $isDebug 是否已经上线
 * @property string $api 登录、充值验证接口
 *
 * @property TabDistributor $distributor
 * @property TabGames $game
 * @property TabNotice[] $tabNotices
 * @property TabServers[] $tabServers
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
            [['gameId', 'distributorId', 'parentDT','ratio', 'enabled', 'isDebug'], 'integer'],
            [['platform'], 'string', 'max' => 50],
            [['centerLoginKey', 'centerPaymentKey'], 'string', 'max' => 32],
            [['appID', 'appKey', 'appLoginKey', 'appPaymentKey', 'appPublicKey'], 'string', 'max' => 255],
            [['api'], 'string', 'max' => 100],
            [['distributorId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistributor::className(), 'targetAttribute' => ['distributorId' => 'id']],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
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
            'enabled' => Yii::t('app', '是否可用'),
            'isDebug' => Yii::t('app', '正在调试'),
            'api' => Yii::t('app', 'SDK名'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributor()
    {
        return $this->hasOne(TabDistributor::className(), ['id' => 'distributorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabNotices()
    {
        return $this->hasMany(TabNotice::className(), ['distributionId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabServers()
    {
        return $this->hasMany(TabServers::className(), ['distributionId' => 'id']);
    }
}
