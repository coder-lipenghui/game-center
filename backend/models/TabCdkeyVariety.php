<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_cdkey_variety".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property string $name 激活码名称
 * @property string $items 激活码对应的物品
 * @property int $once 只能使用1次 1:一次 0:可以重复
 * @property int $type 激活码类型:1普通 2通用
 * @property int $deliverType 发放类型:1 脚本发放 2 邮件发放 
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
            [['gameId', 'name', 'items'], 'required'],
            [['gameId', 'once', 'type', 'deliverType'], 'integer'],
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
            'gameId' => Yii::t('app', 'Game ID'),
            'name' => Yii::t('app', 'Name'),
            'items' => Yii::t('app', 'Items'),
            'once' => Yii::t('app', 'Once'),
            'type' => Yii::t('app', 'Type'),
            'deliverType' => Yii::t('app', 'Deliver Type'),
        ];
    }
    public function getVersion()
    {
        return $this->hasOne(TabGameVersion::className(),['id'=>'gameId']);
    }
}
