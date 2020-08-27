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
 * @property string roleId 角色ID
 * @property string roleName 角色名称
 * @property string $reason 申请理由
 * @property int $type 元宝类型：0:常规 2:模拟充值
 * @property int $productId 计费点ID
 * @property int $number 元宝数量
 * @property int $status 审核状态
 * @property int $deliver 交付状态
 * @property int $verifier 审核人
 * @property string $applyTime 申请时间
 * @property string $consentTime 审核时间
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
            [['sponsor', 'gameId', 'distributorId', 'serverId', 'type', 'number', 'status', 'deliver', 'verifier','productId'], 'integer'],
            [['gameId', 'distributorId', 'serverId', 'roleAccount', 'reason', 'type', 'number'], 'required'],
            [['applyTime', 'consentTime'], 'safe'],
            [['roleAccount', 'roleId','roleName','reason'], 'string', 'max' => 255],
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
            'roleId' => Yii::t('app', '角色'),
            'reason' => Yii::t('app', '理由'),
            'type' => Yii::t('app', '类型'),
            'number' => Yii::t('app', '数量'),
            'status' => Yii::t('app', '状态'),
            'deliver' => Yii::t('app', '到账'),
            'verifier' => Yii::t('app', 'Verifier'),
            'applyTime' => Yii::t('app', '申请时间'),
            'consentTime' => Yii::t('app', '确认时间'),
        ];
    }

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
    public function getSponsorUser()
    {
        return $this->hasOne(User::className(),['id'=>'sponsor']);
    }
    public function getVerifierUser()
    {
        return $this->hasOne(\common\models\User::className(),['id'=>'verifier']);
    }
    public function getProduct()
    {
        return $this->hasOne(TabProduct::className(),['id'=>'productId']);
    }
}
