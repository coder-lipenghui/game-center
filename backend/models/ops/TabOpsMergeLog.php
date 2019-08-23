<?php

namespace backend\models\ops;

use Yii;

/**
 * This is the model class for table "tab_ops_merge_log".
 *
 * @property int $id
 * @property int $distributionId 分销渠道ID
 * @property int $gameId 游戏ID
 * @property string $activeUrl 主动区服url
 * @property string $passiveUrl 被动区服url
 * @property string $logTime 操作时间
 * @property int $uid 操作人员
 */
class TabOpsMergeLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_ops_merge_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distributionId', 'gameId', 'activeUrl', 'passiveUrl', 'logTime', 'uid'], 'required'],
            [['distributionId', 'gameId', 'uid'], 'integer'],
            [['logTime'], 'safe'],
            [['activeUrl', 'passiveUrl'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'distributionId' => Yii::t('app', 'Distribution ID'),
            'gameId' => Yii::t('app', 'Game ID'),
            'activeUrl' => Yii::t('app', 'Active Url'),
            'passiveUrl' => Yii::t('app', 'Passive Url'),
            'logTime' => Yii::t('app', 'Log Time'),
            'uid' => Yii::t('app', 'Uid'),
        ];
    }
}
