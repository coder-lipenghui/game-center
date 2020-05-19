<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_feedback".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributorId 分销商ID
 * @property int $distributionId 分销渠道ID
 * @property int $serverId 区ID
 * @property string $account 账号
 * @property string $roleId 角色ID
 * @property string $roleName 角色名
 * @property string $title 反馈标题
 * @property string $content 反馈内容
 * @property int $state 已读、已回复、暂不处理
 */
class TabFeedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_feedback';
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
            [['distributionId', 'serverId', 'account', 'roleId', 'roleName', 'title', 'content'], 'required'],
            [['gameId', 'distributorId', 'distributionId', 'serverId', 'state'], 'integer'],
            [['account', 'roleName', 'title', 'content'], 'string', 'max' => 255],
            [['roleId'], 'string', 'max' => 200],
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
            'account' => Yii::t('app', 'Account'),
            'roleId' => Yii::t('app', 'Role ID'),
            'roleName' => Yii::t('app', 'Role Name'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'state' => Yii::t('app', 'State'),
        ];
    }
}
