<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_orders_pretest".
 *
 * @property int $id
 * @property int $distributionId 分销渠道ID
 * @property string $distributionUserId 渠道用户ID
 * @property int $total 充值总金额,单位分
 * @property int $rate 充值返利比例
 * @property int $type 充值返利类型：1 不算充值 2 算充值
 * @property int $got 是否领取 0未领取 1已领取
 * @property string $rcvRoleId 领取玩家ID
 * @property string $rcvRoleName 领取玩家名称
 * @property int $rcvServerId 领取区服
 * @property int $rcvTime 领取时间
 */
class TabOrdersPretest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_orders_pretest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distributionId', 'distributionUserId', 'total'], 'required'],
            [['distributionId', 'total', 'rate', 'type', 'got', 'rcvServerId', 'rcvTime'], 'integer'],
            [['distributionUserId', 'rcvRoleId', 'rcvRoleName'], 'string', 'max' => 255],
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
            'distributionUserId' => Yii::t('app', 'Distribution User ID'),
            'total' => Yii::t('app', 'Total'),
            'rate' => Yii::t('app', 'Rate'),
            'type' => Yii::t('app', 'Type'),
            'got' => Yii::t('app', 'Got'),
            'rcvRoleId' => Yii::t('app', 'Rcv Role ID'),
            'rcvRoleName' => Yii::t('app', 'Rcv Role Name'),
            'rcvServerId' => Yii::t('app', 'Rcv Server ID'),
            'rcvTime' => Yii::t('app', 'Rcv Time'),
        ];
    }
    public function getServer()
    {
        return $this->hasOne(TabServers::className(),['id'=>'rcvServerId']);
    }
}
