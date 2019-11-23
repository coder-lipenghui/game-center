<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_bonus_log".
 *
 * @property int $id
 * @property int $gameId
 * @property int $distributorId
 * @property string $orderId
 * @property int $addBindAmount
 * @property int $addUnbindAmount
 * @property string $logTime
 */
class TabBonusLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_bonus_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributorId', 'orderId', 'addBindAmount', 'addUnbindAmount', 'logTime'], 'required'],
            [['gameId', 'distributorId', 'addBindAmount', 'addUnbindAmount'], 'integer'],
            [['logTime'], 'safe'],
            [['orderId'], 'string', 'max' => 255],
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
            'distributorId' => Yii::t('app', 'Distributor ID'),
            'orderId' => Yii::t('app', 'Order ID'),
            'addBindAmount' => Yii::t('app', 'Add Bind Amount'),
            'addUnbindAmount' => Yii::t('app', 'Add Unbind Amount'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
    public function getGame()
    {
        return $this->hasOne(TabGames::className(),['id'=>'gameId']);
    }
    public function getDistributor()
    {
        return $this->hasOne(TabDistributor::className(),['id'=>'distributorId']);
    }
    public function getOrder()
    {
        return $this->hasOne(TabOrders::className(),['orderId'=>'orderId']);
    }
}
