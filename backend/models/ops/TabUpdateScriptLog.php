<?php

namespace backend\models\ops;

use Yii;

/**
 * This is the model class for table "tab_update_script_log".
 *
 * @property int $id
 * @property int $gameId
 * @property int $serverId
 * @property string $scriptName
 * @property string $operator
 * @property int $logTime
 */
class TabUpdateScriptLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_update_script_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'serverId', 'scriptName', 'logTime'], 'required'],
            [['gameId', 'serverId', 'logTime'], 'integer'],
            [['scriptName', 'operator'], 'string', 'max' => 255],
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
            'serverId' => Yii::t('app', 'Server ID'),
            'scriptName' => Yii::t('app', 'Script Name'),
            'operator' => Yii::t('app', 'Operator'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
}
