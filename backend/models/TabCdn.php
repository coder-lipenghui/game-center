<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_cdn".
 *
 * @property int $id
 * @property int $gameId 游戏Id
 * @property string $url CDN地址
 * @property string $platform 云服务商:阿里、腾讯云
 * @property string $secretId 与服务器商提供的id
 * @property string $secretKey
 * @property string $comment
 *
 * @property TabGames $game
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
            [['gameId', 'url'], 'required'],
            [['gameId'], 'integer'],
            [['url', 'secretId', 'secretKey', 'comment'], 'string', 'max' => 255],
            [['platform'], 'string', 'max' => 100],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
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
            'url' => Yii::t('app', 'Url'),
            'platform' => Yii::t('app', 'Platform'),
            'secretId' => Yii::t('app', 'Secret ID'),
            'secretKey' => Yii::t('app', 'Secret Key'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }
}
