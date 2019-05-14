<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_notice".
 *
 * @property int $id
 * @property int $gameid 游戏id
 * @property int $distributionId 分销管理ID
 * @property string $title 公告标题
 * @property string $body 公告正文
 * @property int $starttime 公告开启时间
 * @property int $endtime 公告结束时间
 * @property int $rank 公告排序
 *
 * @property TabDistribution $distribution
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
            [['gameId', 'distributionId', 'title', 'body', 'starttime', 'endtime'], 'required'],
            [['gameId', 'distributionId',  'rank'], 'integer'],
            [['starttime'],'filter','filter' => function(){
                return strtotime($this->starttime);
            }],
            [['endtime'],'filter','filter' => function(){
                return strtotime($this->starttime);
            }],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['distributionId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistribution::className(), 'targetAttribute' => ['distributionId' => 'id']],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
//            [['gameId'],'exist', 'skipOnError' => true, 'targetClass' => TabPermission::className(), 'targetAttribute' => ['gameId' => 'gid'],'filter'=>['uid'=>Yii::$app->user->id]],
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
            'distributionId' => Yii::t('app', '分销'),
            'title' => Yii::t('app', '标题'),
            'body' => Yii::t('app', '内容'),
            'starttime' => Yii::t('app', '开始时间'),
            'endtime' => Yii::t('app', '结束时间'),
            'rank' => Yii::t('app', '排序'),
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
