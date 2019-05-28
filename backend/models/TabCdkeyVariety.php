<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_cdkey_variety".
 *
 * @property int $id
 * @property string $name 激活码名称
 * @property string $items 激活码对应的物品
 * @property int $once 只能使用1次 1:一次 0:可以重复
 */
class TabCdkeyVariety extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_cdkey_variety';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'items'], 'required'],
            [['once'], 'integer'],
            [['name', 'items'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '名称'),
            'items' => Yii::t('app', '物品'),
            'once' => Yii::t('app', '是否可多次使用'),
        ];
    }
}
