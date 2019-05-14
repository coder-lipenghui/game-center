<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_orders".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributionId 分销ID
 * @property string $orderId 系统订单号
 * @property string $distributorOrderId 渠道侧的订单ID
 * @property string $playerId 渠道玩家ID
 * @property string $gameRoleId 游戏seedname
 * @property string $gameRoleName 游戏角色名
 * @property int $gameServerId 游戏服务器id
 * @property string $gameAccount 游戏帐号uniqueKey
 * @property string $goodName 商品名称
 * @property double $payAmount 实际支付金额(单位分)
 * @property string $payStatus 是否已付款 0未支付 1已支付
 * @property string $payMode 支付方式，常规wechat，alipay等
 * @property string $payTime 付款时间
 * @property string $createTime 订单创建时间
 * @property string $delivered 是否已经发货 0未发货 1已发货
 */
class TabOrders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributionId', 'orderId', 'playerId', 'gameRoleId', 'gameServerId', 'gameAccount'], 'required'],
            [['gameId', 'distributionId', 'gameServerId'], 'integer'],
            [['payAmount'], 'number'],
            [['payStatus', 'delivered'], 'string'],
            [['payTime', 'createTime'], 'safe'],
            [['orderId', 'distributorOrderId', 'gameRoleName', 'gameAccount', 'goodName'], 'string', 'max' => 255],
            [['playerId', 'gameRoleId', 'payMode'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gameId' => Yii::t('app', '游戏'),
            'distributionId' => Yii::t('app', '分销商'),
            'orderId' => Yii::t('app', '游戏订单'),
            'distributorOrderId' => Yii::t('app', '渠道订单'),
            'playerId' => Yii::t('app', '渠道账号'),
            'gameRoleId' => Yii::t('app', '角色ID'),
            'gameRoleName' => Yii::t('app', '角色'),
            'gameServerId' => Yii::t('app', '区服'),
            'gameAccount' => Yii::t('app', '账号'),
            'goodName' => Yii::t('app', '物品'),
            'payAmount' => Yii::t('app', '金额'),
            'payStatus' => Yii::t('app', '状态'),
            'payMode' => Yii::t('app', '方式'),
            'payTime' => Yii::t('app', '支付时间'),
            'createTime' => Yii::t('app', '订单时间'),
            'delivered' => Yii::t('app', '发货状态'),
        ];
    }
}
