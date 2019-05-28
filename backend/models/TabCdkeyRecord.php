<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_cdkey_record".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributionId 分销渠道
 * @property string $account 角色账号
 * @property string $roleId 角色ID
 * @property string $roleName 角色名称
 * @property string $cdkey 激活码
 * @property int $logTime 记录时间
 */
class TabCdkeyRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_cdkey_record';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributionId', 'account', 'roleId', 'roleName', 'cdkey', 'logTime'], 'required'],
            [['gameId', 'distributionId', 'logTime'], 'integer'],
            [['account', 'roleId', 'roleName', 'cdkey'], 'string', 'max' => 100],
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
            'account' => Yii::t('app', 'Account'),
            'roleId' => Yii::t('app', 'Role ID'),
            'roleName' => Yii::t('app', 'Role Name'),
            'cdkey' => Yii::t('app', 'Cdkey'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
}
