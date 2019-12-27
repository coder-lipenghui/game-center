<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_servers".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributorId 分销商ID
 * @property string $distributions 分销管理ID，非分销商ID
 * @property int $type 区服类型:1 android 2 ios 3全平台
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
            [['gameId', 'name', 'openDateTime'], 'required'],
            [['gameId', 'distributorId', 'type', 'index', 'status', 'netPort', 'masterPort', 'contentPort', 'smallDbPort', 'bigDbPort', 'mergeId'], 'integer'],
            [['openDateTime', 'createTime'], 'safe'],
            [['distributions', 'name', 'url'], 'string', 'max' => 255],
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
            'distributions' => Yii::t('app', 'Distributions'),
            'type' => Yii::t('app', 'Type'),
            'name' => Yii::t('app', 'Name'),
            'index' => Yii::t('app', 'Index'),
            'status' => Yii::t('app', 'Status'),
            'url' => Yii::t('app', 'Url'),
            'netPort' => Yii::t('app', 'Net Port'),
            'masterPort' => Yii::t('app', 'Master Port'),
            'contentPort' => Yii::t('app', 'Content Port'),
            'smallDbPort' => Yii::t('app', 'Small Db Port'),
            'bigDbPort' => Yii::t('app', 'Big Db Port'),
            'mergeId' => Yii::t('app', 'Merge ID'),
            'openDateTime' => Yii::t('app', 'Open Date Time'),
            'createTime' => Yii::t('app', 'Create Time'),
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
}
