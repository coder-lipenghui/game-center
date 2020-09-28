<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_game_update".
 *
 * @property int $id
 * @property int $versionId 版本ID
 * @property int $gameId 游戏ID
 * @property int $distributionId 分销渠道ID
 * @property string $versionFile 更新版本号描述文件
 * @property string $projectFile 更新内容描述文件
 * @property int $version 版本号
 * @property int $executeTime 开启时间
 * @property int $enable 是否开启
 * @property string $svn SVN版本号
 * @property string $comment 备注信息
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
            [['versionId', 'versionFile', 'projectFile', 'version', 'executeTime', 'svn', 'comment'], 'required'],
            [['versionId', 'gameId', 'distributionId', 'version', 'enable'], 'integer'],
            [['versionFile', 'projectFile'], 'string', 'max' => 100],
            [['svn', 'comment'], 'string', 'max' => 255],
            [['executeTime'],'filter','filter'=>function(){
                return strtotime($this->executeTime);
            }],
            [['versionFile'],'filter','filter'=>function(){
                return $this->versionFile.".manifest";
            }],
            [['projectFile'],'filter','filter'=>function(){
                return $this->projectFile.".manifest";
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'versionId' => Yii::t('app', 'Version ID'),
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
    public function getGameVersion()
    {
        return $this->hasOne(TabGameVersion::className(),['id'=>'versionId']);
    }
}
