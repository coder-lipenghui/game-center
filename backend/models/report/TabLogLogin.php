<?php

namespace backend\models\report;

use Yii;

/**
 * This is the model class for table "tab_log_login".
 *
 * @property int $id
 * @property string $account 中控用户ID
 * @property string $distributionUserId 渠道用户ID
 * @property int $gameId 游戏ID
 * @property int $distributionId 渠道ID
 * @property int $serverId 区服ID
 * @property string $roleId 角色ID
 * @property string $roleName 角色名称
 * @property int $roleLevel 角色等级
 * @property string $deviceVender 设备厂商
 * @property string $deviceOs 设备系统
 * @property string $deviceId 设备ID
 * @property int $logTime 记录时间
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
            [['account', 'distributionUserId', 'gameId', 'distributionId', 'serverId', 'roleId', 'roleName', 'roleLevel', 'logTime'], 'required'],
            [['gameId', 'distributionId', 'serverId', 'roleLevel', 'logTime'], 'integer'],
            [['account', 'distributionUserId', 'roleId', 'roleName', 'deviceVender', 'deviceOs', 'deviceId'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'account' => Yii::t('app', 'Account'),
            'distributionUserId' => Yii::t('app', 'Distribution User ID'),
            'gameId' => Yii::t('app', 'Game ID'),
            'distributionId' => Yii::t('app', 'Distribution ID'),
            'serverId' => Yii::t('app', 'Server ID'),
            'roleId' => Yii::t('app', 'Role ID'),
            'roleName' => Yii::t('app', 'Role Name'),
            'roleLevel' => Yii::t('app', 'Role Level'),
            'deviceVender' => Yii::t('app', 'Device Vender'),
            'deviceOs' => Yii::t('app', 'Device Os'),
            'deviceId' => Yii::t('app', 'Device ID'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
}
