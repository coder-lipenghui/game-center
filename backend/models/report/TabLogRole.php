<?php

namespace backend\models\report;

use Yii;

/**
 * This is the model class for table "tab_log_role".
 *
 * @property int $id
 * @property string $distributionUserId 渠道用户ID
 * @property string $account 中控分配的账号
 * @property int $gameId 游戏ID
 * @property int $distributionId 渠道ID
 * @property int $serverId 区服ID
 * @property string $roleId 角色唯一ID
 * @property string $roleName 角色名称
 * @property int $createTime 角色创建时间
 * @property int $logTime 记录时间
 */
class TabLogRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_log_role';
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
            [['distributionUserId', 'account', 'gameId', 'distributionId', 'serverId', 'roleId', 'roleName', 'createTime', 'logTime'], 'required'],
            [['gameId', 'distributionId', 'serverId', 'createTime', 'logTime'], 'integer'],
            [['distributionUserId', 'account', 'roleId', 'roleName'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'distributionUserId' => Yii::t('app', 'Distribution User ID'),
            'account' => Yii::t('app', 'Account'),
            'gameId' => Yii::t('app', 'Game ID'),
            'distributionId' => Yii::t('app', 'Distribution ID'),
            'serverId' => Yii::t('app', 'Server ID'),
            'roleId' => Yii::t('app', 'Role ID'),
            'roleName' => Yii::t('app', 'Role Name'),
            'createTime' => Yii::t('app', 'Create Time'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
}
