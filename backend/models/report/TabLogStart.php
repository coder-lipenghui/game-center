<?php

namespace backend\models\report;

use Yii;

/**
 * This is the model class for table "tab_log_start".
 *
 * @property int $id
 * @property string $ip
 * @property string $deviceId
 * @property string $deviceOs
 * @property string $deviceName
 * @property string $deviceVender
 * @property int $logTime
 */
class TabLogStart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_log_start';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_log');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'deviceOs', 'deviceVender', 'logTime'], 'required'],
            [['logTime'], 'integer'],
            [['ip', 'deviceId', 'deviceOs', 'deviceName', 'deviceVender'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', 'Ip'),
            'deviceId' => Yii::t('app', 'Device ID'),
            'deviceOs' => Yii::t('app', 'Device Os'),
            'deviceName' => Yii::t('app', 'Device Name'),
            'deviceVender' => Yii::t('app', 'Device Vender'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
}
