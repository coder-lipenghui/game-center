<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_cdkey".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributorId 分销商ID
 * @property int $distributionId 分销渠道ID
 * @property int $varietyId 激活码分类ID
 * @property string $cdkey 激活码
 * @property int $used 是否使用：0未使用 1:使用过
 * @property int $createTime 创建时间
 *
 * @property TabCdkeyVariety $variety
 */
class TabCdkey extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_cdkey';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributorId', 'varietyId', 'cdkey', 'createTime'], 'required'],
            [['gameId', 'distributorId', 'distributionId', 'varietyId', 'used', 'createTime'], 'integer'],
            [['cdkey'], 'string', 'max' => 100],
            [['varietyId'], 'exist', 'skipOnError' => true, 'targetClass' => TabCdkeyVariety::className(), 'targetAttribute' => ['varietyId' => 'id']],
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
            'distributorId' => Yii::t('app', '分销商'),
            'distributionId' => Yii::t('app', '分销渠道'),
            'varietyId' => Yii::t('app', '激活码类型'),
            'cdkey' => Yii::t('app', 'Cdkey'),
            'used' => Yii::t('app', 'Used'),
            'createTime' => Yii::t('app', 'Create Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariety()
    {
        return $this->hasOne(TabCdkeyVariety::className(), ['id' => 'varietyId']);
    }
}
