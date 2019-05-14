<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_servers".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributions 分销管理ID，非分销商ID
 * @property string $name 区服名称
 * @property int $index 根据分销渠道的递增ID
 * @property int $status 区服状态,1:新服 2:正常 3:白名单 4:维护中 5:未开区 6:自动开区
 * @property string $url 游戏域名、IP
 * @property int $netPort 游戏NET端口
 * @property int $masterPort 游戏MASTER端口
 * @property int $contentPort 游戏Content端口
 * @property int $smallDbPort 游戏主数据库端口
 * @property int $bigDbPort 游戏日志数据库端口
 * @property int $mergeId 合区主区ID
 * @property string $openDateTime 开服时间
 * @property string $createTime 创建时间
 *
 * @property TabDistribution $distribution
 * @property TabGames $game
 */
class TabServers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_servers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'name', 'openDateTime','index','netPort', 'masterPort', 'contentPort', 'smallDbPort', 'bigDbPort','url'], 'required'],
            [['gameId', 'index', 'status', 'netPort', 'masterPort', 'contentPort', 'smallDbPort', 'bigDbPort', 'mergeId'], 'integer'],
            [['openDateTime', 'createTime'], 'safe'],
            [['name', 'url','distributions'], 'string', 'max' => 255],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gameId' => Yii::t('app', '游戏ID'),
            'distributions' => Yii::t('app', '设备平台'),
            'name' => Yii::t('app', '区服名称'),
            'index' => Yii::t('app', '显示ID'),
            'status' => Yii::t('app', '状态'),
            'url' => Yii::t('app', '域名'),
            'netPort' => Yii::t('app', 'Net端口'),
            'masterPort' => Yii::t('app', 'Master端口'),
            'contentPort' => Yii::t('app', 'Content端口'),
            'smallDbPort' => Yii::t('app', 'DB小端口'),
            'bigDbPort' => Yii::t('app', 'DB大端口'),
            'mergeId' => Yii::t('app', '已合区至'),
            'openDateTime' => Yii::t('app', '开区时间'),
            'createTime' => Yii::t('app', '创建时间'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getDistribution()
//    {
//        return $this->hasOne(TabDistribution::className(), ['id' => 'distributionId']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }
}
