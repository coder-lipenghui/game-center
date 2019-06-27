<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_game_update".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributionId 分销渠道ID
 * @property string $versionFile
 * @property string $projectFile
 * @property string $version 版本信息
 * @property int $executeTime 开启时间
 * @property int $enable 是否开启
 * @property string $svn SVN版本号
 * @property string $comment 备注信息
 *
 * @property TabDistribution $distribution
 * @property TabGames $game
 */
class TabGameUpdate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_game_update';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'versionFile', 'projectFile','executeTime'], 'required'],
            [['gameId', 'distributionId', 'enable'], 'integer'],
            [['executeTime'],'filter','filter'=>function(){
                return strtotime($this->executeTime);
            }],
            [['versionFile'],'filter','filter'=>function(){
                return $this->versionFile.".manifest";
            }],
            [['projectFile'],'filter','filter'=>function(){
                return $this->projectFile.".manifest";
            }],
            [['versionFile', 'projectFile', 'version'], 'string', 'max' => 100],
            [['svn', 'comment'], 'string', 'max' => 255],
            [['distributionId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistribution::className(), 'targetAttribute' => ['distributionId' => 'id']],
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
            'gameId' => Yii::t('app', '游戏'),
            'distributionId' => Yii::t('app', '渠道'),
            'versionFile' => Yii::t('app', '版本文件'),
            'projectFile' => Yii::t('app', '内容文件'),
            'version' => Yii::t('app', '版本号'),
            'executeTime' => Yii::t('app', '更新时间'),
            'enable' => Yii::t('app', '是否启用'),
            'svn' => Yii::t('app', 'Svn信息'),
            'comment' => Yii::t('app', '备注'),
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
}
