<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_players".
 *
 * @property int $id
 * @property int $distributionId 分校渠道ID
 * @property int $distributorId 渠道商ID
 * @property int $channel 子渠道编号，QUICK等聚合SDK使用
 * @property int $gameId 游戏编号
 * @property string $account 系统分配的唯一标识
 * @property string $distributionUserId 分销商用户ID
 * @property string $distributionUserAccount 分销商用户账号
 * @property string $regdeviceId 设备ID
 * @property string $regtime 注册时间
 * @property string $regip 注册IP
 */
class TabPlayers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_players';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distributionId', 'gameId', 'account', 'distributionUserId', 'distributionUserAccount'], 'required'],
            [['distributionId', 'distributorId', 'channel', 'gameId'], 'integer'],
            [['regtime'], 'safe'],
            [['account', 'distributionUserId', 'regdeviceId', 'regip'], 'string', 'max' => 255],
            [['distributionUserAccount'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'distributionId' => Yii::t('app', 'Distribution ID'),
            'distributorId' => Yii::t('app', 'Distributor ID'),
            'channel' => Yii::t('app', 'Channel'),
            'gameId' => Yii::t('app', 'Game ID'),
            'account' => Yii::t('app', 'Account'),
            'distributionUserId' => Yii::t('app', 'Distribution User ID'),
            'distributionUserAccount' => Yii::t('app', 'Distribution User Account'),
            'regdeviceId' => Yii::t('app', 'Regdevice ID'),
            'regtime' => Yii::t('app', 'Regtime'),
            'regip' => Yii::t('app', 'Regip'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }
    public function getDistributor()
    {
        return $this->hasOne(TabDistributor::className(),['id'=>'distributorId']);
    }
}
