<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_whitelist".
 *
 * @property int $id
 * @property int $gameId 白名单游戏ID
 * @property int $distributionId 白名单渠道ID
 * @property string $ip
 * @property string $distributionUserId
 */
class TabWhitelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_whitelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributionId'], 'required'],
            [['gameId', 'distributionId'], 'integer'],
            [['ip', 'distributionUserId'], 'string', 'max' => 255],
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
            'distributionId' => Yii::t('app', 'Distribution ID'),
            'ip' => Yii::t('app', 'Ip'),
            'distributionUserId' => Yii::t('app', 'Distribution User ID'),
        ];
    }
}
