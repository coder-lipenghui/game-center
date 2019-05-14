<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_distributor".
 *
 * @property int $id
 * @property string $name 分销商名称
 * @property string $contacts 分销商联系人
 * @property string $phone 联系人电话
 * @property string $address 联系地址
 * @property int $isuse
 * @property string $create_time
 *
 * @property TabDistribution[] $tabDistributions
 */
class TabDistributor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_distributor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'isuse'], 'required'],
            [['isuse'], 'integer'],
            [['create_time'], 'safe'],
            [['name', 'contacts'], 'string', 'max' => 45],
            [['phone'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '分销商ID'),
            'name' => Yii::t('app', '分销商名称'),
            'contacts' => Yii::t('app', '联系人'),
            'phone' => Yii::t('app', '电话'),
            'address' => Yii::t('app', '地址'),
            'isuse' => Yii::t('app', '是否开启'),
            'create_time' => Yii::t('app', '接入时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabDistributions()
    {
        return $this->hasMany(TabDistribution::className(), ['distributorId' => 'id']);
    }
}
