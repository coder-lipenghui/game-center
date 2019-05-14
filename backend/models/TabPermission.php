<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tab_permission".
 *
 * @property int $id
 * @property int $uid 用户id
 * @property int $gameId 游戏id
 * @property int $distributorId 分销商ID
 * @property int $distributionId 分销渠道ID
 * @property string $description 备注
 *
 * @property TabGames $game
 * @property User $u
 * @property TabDistribution $distribution
 * @property TabDistributor $distributor
 */
class TabPermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_permission';
    }
    public  static function getGames()
    {
        $query=TabPermission::find();
        $query->select(['id'=>'tab_permission.gameId','name'=>'tab_games.name'])
            ->join('LEFT JOIN','tab_games','tab_permission.gameId=tab_games.id')
            ->where(['uid'=>Yii::$app->user->id])->asArray();
        $data=$query->all();
//        exit(print_r($data));
        return ArrayHelper::map($data,'id','name');
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', '用户'),
            'gameId' => Yii::t('app', '游戏名称'),
            'distributorId' => Yii::t('app', '分销商'),
            'distributionId' => Yii::t('app', '设备平台'),
            'description' => Yii::t('app', '备注'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'gameId', 'distributorId', 'distributionId'], 'required'],
            [['uid', 'gameId', 'distributorId', 'distributionId'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
            [['distributionId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistribution::className(), 'targetAttribute' => ['distributionId' => 'id']],
            [['distributorId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistributor::className(), 'targetAttribute' => ['distributorId' => 'id']],
        ];
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
    public function getU()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
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
    public function getDistributor()
    {
        return $this->hasOne(TabDistributor::className(), ['id' => 'distributorId']);
    }
}
