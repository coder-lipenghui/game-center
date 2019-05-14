<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_orders_log".
 *
 * @property int $id
 * @property int $gameid 游戏ID
 * @property int $distributor 分销ID
 * @property string $orderid 系统订单号
 * @property string $distributorOrderid 渠道侧的订单ID
 * @property string $player_id 渠道玩家ID
 * @property string $gameRoleid 游戏seedname
 * @property string $gameRoleName 游戏角色名称
 * @property int $gameServerId 游戏服务器id
 * @property string $gameAccount 游戏帐号uniqueKey
 * @property double $total 订单总价
 * @property double $vcoinRatio 虚拟货币比例
 * @property double $paymoney 实际支付金额
 * @property string $payTime 付款时间
 * @property string $orderTime 订单时间
 * @property string $deviceId 设备ID
 * @property int $isDebug 是否是测试支付
 */
class TabOrdersLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_orders_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameid', 'distributor', 'orderid', 'player_id', 'gameRoleid', 'gameServerId', 'gameAccount', 'total'], 'required'],
            [['gameid', 'distributor', 'gameServerId', 'isDebug'], 'integer'],
            [['total', 'vcoinRatio', 'paymoney'], 'number'],
            [['payTime', 'orderTime'], 'safe'],
            [['orderid', 'distributorOrderid', 'gameRoleName', 'gameAccount', 'deviceId'], 'string', 'max' => 255],
            [['player_id', 'gameRoleid'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gameid' => Yii::t('app', 'Gameid'),
            'distributor' => Yii::t('app', 'Distributor'),
            'orderid' => Yii::t('app', 'Orderid'),
            'distributorOrderid' => Yii::t('app', 'Distributor Orderid'),
            'player_id' => Yii::t('app', 'Player ID'),
            'gameRoleid' => Yii::t('app', 'Game Roleid'),
            'gameRoleName' => Yii::t('app', 'Game Role Name'),
            'gameServerId' => Yii::t('app', 'Game Server ID'),
            'gameAccount' => Yii::t('app', 'Game Account'),
            'total' => Yii::t('app', 'Total'),
            'vcoinRatio' => Yii::t('app', 'Vcoin Ratio'),
            'paymoney' => Yii::t('app', 'Paymoney'),
            'payTime' => Yii::t('app', 'Pay Time'),
            'orderTime' => Yii::t('app', 'Order Time'),
            'deviceId' => Yii::t('app', 'Device ID'),
            'isDebug' => Yii::t('app', 'Is Debug'),
        ];
    }
}
