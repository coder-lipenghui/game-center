<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_orders".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributorId 分销商ID
 * @property int $distributionId 分销ID
 * @property string $orderId 系统订单号
 * @property string $distributionOrderId 渠道侧的订单ID
 * @property string $distributionUserId 渠道玩家ID
 * @property string $gameRoleId 游戏seedname
 * @property string $gameRoleName 游戏角色名
 * @property int $gameServerId 游戏服务器id
 * @property string $gameServername
 * @property string $gameAccount 游戏帐号uniqueKey
 * @property int $productId 商品ID
 * @property string $productName 商品名称
 * @property double $payAmount 订单金额
 * @property string $payStatus 是否已付款 0未支付 1已支付
 * @property string $payMode 支付方式，常规wechat，alipay等
 * @property int $payTime 付款时间
 * @property int $createTime 订单创建时间
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
            [['gameId', 'distributionId', 'orderId', 'distributionUserId', 'gameRoleId', 'gameServerId', 'gameServername', 'gameAccount', 'productId'], 'required'],
            [['gameId', 'distributorId', 'distributionId', 'gameServerId', 'productId', 'payTime', 'createTime'], 'integer'],
            [['payAmount'], 'number'],
            [['payStatus', 'delivered'], 'string'],
            [['orderId', 'distributionOrderId', 'gameRoleName', 'gameAccount', 'productName'], 'string', 'max' => 255],
            [['distributionUserId', 'gameRoleId', 'payMode'], 'string', 'max' => 100],
            [['gameServername'], 'string', 'max' => 50],
            [['orderId'], 'unique'],
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
            'distributionId' => Yii::t('app', 'Distribution ID'),
            'orderId' => Yii::t('app', 'Order ID'),
            'distributionOrderId' => Yii::t('app', 'Distribution Order ID'),
            'distributionUserId' => Yii::t('app', 'Distribution User ID'),
            'gameRoleId' => Yii::t('app', 'Game Role ID'),
            'gameRoleName' => Yii::t('app', 'Game Role Name'),
            'gameServerId' => Yii::t('app', 'Game Server ID'),
            'gameServername' => Yii::t('app', 'Game Servername'),
            'gameAccount' => Yii::t('app', 'Game Account'),
            'productId' => Yii::t('app', 'Product ID'),
            'productName' => Yii::t('app', 'Product Name'),
            'payAmount' => Yii::t('app', 'Pay Amount'),
            'payStatus' => Yii::t('app', 'Pay Status'),
            'payMode' => Yii::t('app', 'Pay Mode'),
            'payTime' => Yii::t('app', 'Pay Time'),
            'createTime' => Yii::t('app', 'Create Time'),
            'delivered' => Yii::t('app', 'Delivered'),
        ];
    }
    public function getGame()
    {
        return $this->hasOne(TabGames::className(),['id'=>'gameId']);
    }
    public function getServer()
    {
        return $this->hasOne(TabServers::className(),['id'=>'gameServerId']);
    }
}
