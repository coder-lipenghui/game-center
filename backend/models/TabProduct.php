<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_product".
 *
 * @property int $id
 * @property int $gameId 游戏Id
 * @property int $type 商品类型:1充值货币、2充值物品
 * @property int $productId 商品ID
 * @property string $productName 商品名称
 * @property int $productPrice 商品价格分
 * @property string $productScript 商品描述
 * @property int $enable 是否可用
 */
class TabProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'productId', 'productName', 'productPrice'], 'required'],
            [['gameId', 'type', 'productId', 'productPrice', 'enable'], 'integer'],
            [['productName', 'productScript'], 'string', 'max' => 255],
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
            'type' => Yii::t('app', 'Type'),
            'productId' => Yii::t('app', 'Product ID'),
            'productName' => Yii::t('app', 'Product Name'),
            'productPrice' => Yii::t('app', 'Product Price'),
            'productScript' => Yii::t('app', 'Product Script'),
            'enable' => Yii::t('app', 'Enable'),
        ];
    }
    public function getGame()
    {
        return $this->hasOne(TabGameVersion::className(),['id'=>'gameId']);
    }
}
