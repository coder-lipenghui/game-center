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
 * @property string $versionCode versionCode
 * @property string $versionName versionName
 * @property int $total 分包总数
 * @property int $executeTime 开启时间
 * @property int $enable 是否开启
 * @property string $comment 备注信息
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
            [['gameId', 'total'], 'required'],
            [['gameId', 'distributionId', 'total', 'executeTime', 'enable'], 'integer'],
            [['versionFile', 'projectFile', 'versionCode', 'versionName'], 'string', 'max' => 100],
            [['comment'], 'string', 'max' => 255],
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
            'versionCode' => Yii::t('app', 'Version Code'),
            'versionName' => Yii::t('app', 'Version Name'),
            'total' => Yii::t('app', 'Total'),
            'executeTime' => Yii::t('app', 'Execute Time'),
            'enable' => Yii::t('app', 'Enable'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }
}
