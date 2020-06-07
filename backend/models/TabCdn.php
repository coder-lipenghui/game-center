<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_cdn".
 *
 * @property int $id
 * @property int $gameId 游戏Id
 * @property string $updateUrl 更新地址
 * @property string $assetsUrl 分包资源地址
 * @property string $platform 云服务商:阿里、腾讯云
 * @property string $secretId 与服务器商提供的id
 * @property string $secretKey
 * @property string $comment
 */
class TabCdn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_cdn';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'updateUrl', 'assetsUrl'], 'required'],
            [['gameId'], 'integer'],
            [['updateUrl', 'assetsUrl', 'secretId', 'secretKey', 'comment'], 'string', 'max' => 255],
            [['platform'], 'string', 'max' => 100],
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
            'updateUrl' => Yii::t('app', 'Update Url'),
            'assetsUrl' => Yii::t('app', 'Assets Url'),
            'platform' => Yii::t('app', 'Platform'),
            'secretId' => Yii::t('app', 'Secret ID'),
            'secretKey' => Yii::t('app', 'Secret Key'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }
}
