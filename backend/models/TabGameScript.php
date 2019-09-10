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
            [['gameId', 'fileName', 'fileSize', 'userId', 'comment', 'logTime'], 'required'],
            [['gameId', 'userId', 'logTime'], 'integer'],
            [['fileSize'], 'number'],
            [['fileName', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gameId' => Yii::t('app', '游戏名称'),
            'fileName' => Yii::t('app', '脚本名称'),
            'fileSize' => Yii::t('app', '脚本大小'),
            'userId' => Yii::t('app', '上传人'),
            'comment' => Yii::t('app', '备注'),
            'logTime' => Yii::t('app', '上传时间'),
        ];
    }
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }
}
