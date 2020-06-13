<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_cdkey_export".
 *
 * @property int $id
 * @property int $userId
 * @property int $gameId
 * @property int $distributorId
 * @property int $varietyId
 * @property int $num
 * @property int $lastId
 * @property int $logTime
 */
class TabCdkeyExport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_cdkey_export';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId', 'gameId', 'distributorId', 'varietyId', 'num', 'lastId'], 'required'],
            [['userId', 'gameId', 'distributorId', 'varietyId', 'num', 'lastId', 'logTime'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'gameId' => Yii::t('app', 'Game ID'),
            'distributorId' => Yii::t('app', 'Distributor ID'),
            'varietyId' => Yii::t('app', 'Variety ID'),
            'num' => Yii::t('app', 'Num'),
            'lastId' => Yii::t('app', 'Last ID'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
}
