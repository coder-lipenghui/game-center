<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_game_script".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property string $fileName 脚本名称
 * @property double $fileSize 文件大小
 * @property int $userId 上传人
 * @property string $comment 备注
 * @property string $md5 上传文件的MD5值
 * @property int $logTime 记录时间
 */
class TabGameScript extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_game_script';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'fileName', 'fileSize', 'userId', 'comment', 'md5', 'logTime'], 'required'],
            [['gameId', 'userId', 'logTime'], 'integer'],
            [['fileSize'], 'number'],
            [['fileName', 'comment'], 'string', 'max' => 255],
            [['md5'], 'string', 'max' => 100],
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
            'fileName' => Yii::t('app', 'File Name'),
            'fileSize' => Yii::t('app', 'File Size'),
            'userId' => Yii::t('app', 'User ID'),
            'comment' => Yii::t('app', 'Comment'),
            'md5' => Yii::t('app', 'Md5'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }
}
