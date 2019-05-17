<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_notice".
 *
 * @property int $id
 * @property int $gameId 游戏id
 * @property string $distributions 分销管理ID
 * @property string $title 公告标题
 * @property string $body 公告正文
 * @property int $starttime 公告开启时间
 * @property int $endtime 公告结束时间
 * @property int $rank 公告排序
 *
 * @property TabGames $game
 */
class TabNotice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_notice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributions', 'title', 'body', 'starttime', 'endtime'], 'required'],
            [['gameId', 'starttime', 'endtime', 'rank'], 'integer'],
            [['body'], 'string'],
            [['distributions'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 255],
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
            'distributions' => Yii::t('app', 'Distributions'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'starttime' => Yii::t('app', 'Starttime'),
            'endtime' => Yii::t('app', 'Endtime'),
            'rank' => Yii::t('app', 'Rank'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }
}
