<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_server_naming".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributorId 分销商ID
 * @property int $distributionId 分销渠道ID
 * @property int $serverId 区服ID
 * @property string $naming 冠名名称
 * @property int $logTime
 */
class TabServerNaming extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_server_naming';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributorId', 'serverId', 'naming'], 'required'],
            [['gameId', 'distributorId', 'distributionId', 'serverId', 'logTime'], 'integer'],
            [['naming'], 'string', 'max' => 255],
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
            'distributorId' => Yii::t('app', 'Distributor ID'),
            'distributionId' => Yii::t('app', 'Distribution ID'),
            'serverId' => Yii::t('app', 'Server ID'),
            'naming' => Yii::t('app', 'Naming'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
}
