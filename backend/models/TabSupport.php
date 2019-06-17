<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_support".
 *
 * @property int $id
 * @property int $sponsor 申请人ID
 * @property int $gameId 游戏ID
 * @property int $distributorId 分销商ID
 * @property int $serverId 区服ID
 * @property string $roleAccount 角色账号
 * @property string $roleName 角色名称
 * @property string $reason 申请理由
 * @property int $type 元宝类型：0:常规 2:模拟充值
 * @property int $number 元宝数量
 * @property int $status 审核状态
 * @property int $deliver 交付状态
 * @property int $verifier 审核人
 *
 * @property TabGames $game
 */
class TabSupport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_support';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sponsor', 'gameId', 'distributorId', 'serverId', 'type', 'number', 'status','deliver', 'verifier'], 'integer'],
            [['gameId', 'distributorId', 'serverId', 'roleAccount', 'reason', 'type', 'number'], 'required'],
            [['roleAccount', 'reason','roleName'], 'string', 'max' => 255],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
            [['roleAccount'],'exist','skipOnError' => false,'targetClass'=>TabPlayers::className(),'targetAttribute'=>['roleAccount'=>'account']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sponsor' => Yii::t('app', '申请人'),
            'gameId' => Yii::t('app', '游戏'),
            'distributorId' => Yii::t('app', '渠道'),
            'serverId' => Yii::t('app', '区服'),
            'roleAccount' => Yii::t('app', '账号'),
            'roleName' => Yii::t('app', '名称'),
            'reason' => Yii::t('app', '理由'),
            'type' => Yii::t('app', '类型'),
            'number' => Yii::t('app', '数量'),
            'status' => Yii::t('app', '状态'),
            'deliver' => Yii::t('app', '发货'),
            'verifier' => Yii::t('app', '审核人'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }
    public function getDistributor()
    {
        return $this->hasOne(TabDistributor::className(),['id'=>'distributorId']);
    }
    public function getServer()
    {
        return $this->hasOne(TabServers::className(),['id'=>'serverId']);
    }
    public function getUser()
    {
        return $this->hasOne(TabPlayers::className(),['account'=>'roleAccount']);
    }
}
