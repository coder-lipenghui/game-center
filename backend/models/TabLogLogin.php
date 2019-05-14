<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_log_login".
 *
 * @property int $id
 * @property int $gameid
 * @property string $distributor
 * @property int $playerId
 * @property string $ipAddress 登录的客户端IP
 * @property string $deviceOs 登录设备所用操作系统
 * @property string $deviceVender 登录设备生产商
 * @property string $deviceId 登录设备ID
 * @property string $deviceType 登录设备型号
 * @property string $timestamp
 * @property string $loginKey
 * @property string $token
 */
class TabLogLogin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_log_login';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameid', 'playerId', 'ipAddress', 'token'], 'required'],
            [['gameid', 'playerId'], 'integer'],
            [['timestamp'], 'safe'],
            [['distributor'], 'string', 'max' => 255],
            [['ipAddress', 'deviceOs', 'deviceVender', 'deviceType'], 'string', 'max' => 45],
            [['deviceId'], 'string', 'max' => 50],
            [['loginKey'], 'string', 'max' => 100],
            [['token'], 'string', 'max' => 512],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gameid' => Yii::t('app', 'Gameid'),
            'distributor' => Yii::t('app', 'Distributor'),
            'playerId' => Yii::t('app', 'Player ID'),
            'ipAddress' => Yii::t('app', 'Ip Address'),
            'deviceOs' => Yii::t('app', 'Device Os'),
            'deviceVender' => Yii::t('app', 'Device Vender'),
            'deviceId' => Yii::t('app', 'Device ID'),
            'deviceType' => Yii::t('app', 'Device Type'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'loginKey' => Yii::t('app', 'Login Key'),
            'token' => Yii::t('app', 'Token'),
        ];
    }
}
