<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_blacklist".
 *
 * @property int $id
 * @property int $gameId
 * @property string $ip
 * @property string $distributionUserId
 * @property string $deviceId
 */
class TabBlacklist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_blacklist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId'], 'required'],
            [['gameId'], 'integer'],
            [['ip', 'distributionUserId', 'deviceId'], 'string', 'max' => 255],
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
            'ip' => Yii::t('app', 'Ip'),
            'distributionUserId' => Yii::t('app', 'Distribution User ID'),
            'deviceId' => Yii::t('app', 'Device ID'),
        ];
    }
}
