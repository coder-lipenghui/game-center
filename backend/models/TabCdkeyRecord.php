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
 * @property int $serverId 区服ID
 * @property string $roleId 角色ID
 * @property string $roleName 角色名称
 * @property int $varietyId 激活码分类ID
 * @property string $cdkey 激活码
 * @property int $logTime 记录时间
 *
 * @property TabDistribution $distribution
 * @property TabGames $game
 * @property TabServers $server
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
            [['gameId', 'distributionId', 'account', 'serverId', 'roleId', 'roleName', 'cdkey', 'logTime','varietyId'], 'required'],
            [['gameId', 'distributionId', 'serverId', 'logTime','varietyId'], 'integer'],
            [['account', 'roleId', 'roleName', 'cdkey'], 'string', 'max' => 100],
            [['distributionId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistribution::className(), 'targetAttribute' => ['distributionId' => 'id']],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
            [['serverId'], 'exist', 'skipOnError' => true, 'targetClass' => TabServers::className(), 'targetAttribute' => ['serverId' => 'id']],
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
            'serverId' => Yii::t('app', 'Server ID'),
            'roleId' => Yii::t('app', 'Role ID'),
            'roleName' => Yii::t('app', 'Role Name'),
            'varietyId'=> Yii::t('app', 'Variety Id'),
            'cdkey' => Yii::t('app', 'Cdkey'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistribution()
    {
        return $this->hasOne(TabDistribution::className(), ['id' => 'distributionId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServer()
    {
        return $this->hasOne(TabServers::className(), ['id' => 'serverId']);
    }
}
