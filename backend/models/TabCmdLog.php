<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_cmd_log".
 *
 * @property int $id
 * @property int $gameId
 * @property int $serverId
 * @property int $type 命令类型：对玩家，对服务器
 * @property string $cmdName 命令名称
 * @property string $cmdInfo 命令内容
 * @property int $operator
 * @property int $status 命令执行状态
 * @property string $result 命令返回结果
 * @property int $logTime 记录时间
 */
class TabCmdLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_cmd_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'type', 'cmdName', 'operator', 'status', 'logTime'], 'required'],
            [['gameId', 'serverId', 'type', 'operator', 'status', 'logTime'], 'integer'],
            [['cmdName', 'cmdInfo', 'result'], 'string', 'max' => 255],
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
            'serverId' => Yii::t('app', 'Server ID'),
            'type' => Yii::t('app', 'Type'),
            'cmdName' => Yii::t('app', 'Cmd Name'),
            'cmdInfo' => Yii::t('app', 'Cmd Info'),
            'operator' => Yii::t('app', 'Operator'),
            'status' => Yii::t('app', 'Status'),
            'result' => Yii::t('app', 'Result'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
    public function getGame()
    {
        return $this->hasOne(TabGames::className(),['id'=>'gameId']);
    }
    public function getCmd()
    {
        return $this->hasOne(TabCmd::className(),['id'=>'cmdName']);
    }
    public function getServer()
    {
        return $this->hasOne(TabServers::className(),['id'=>'serverId']);
    }
    public function getDistributor()
    {
        return $this->hasOne(TabDistributor::className(),['id'=>'distributorId']);
    }
}
