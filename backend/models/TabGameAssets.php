<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_game_assets".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributionId 分销渠道ID
 * @property string $versionFile
 * @property string $projectFile
 * @property int $version 版本号
 * @property int $executeTime 开启时间
 * @property int $enable 是否开启
 * @property string $svn SVN版本号
 * @property string $comment 备注信息
 *
 * @property TabDistribution $distribution
 * @property TabGames $game
 */
class TabGameAssets extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_game_assets';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'projectFile', 'version'], 'required'],
            [['gameId', 'distributionId', 'version', 'executeTime', 'enable'], 'integer'],
            [['versionFile', 'projectFile'], 'string', 'max' => 100],
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
            'gameId' => Yii::t('app', 'Game ID'),
            'distributionId' => Yii::t('app', 'Distribution ID'),
            'versionFile' => Yii::t('app', 'Version File'),
            'projectFile' => Yii::t('app', 'Project File'),
            'version' => Yii::t('app', 'Version'),
            'executeTime' => Yii::t('app', 'Execute Time'),
            'enable' => Yii::t('app', 'Enable'),
            'svn' => Yii::t('app', 'Svn'),
            'comment' => Yii::t('app', 'Comment'),
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
