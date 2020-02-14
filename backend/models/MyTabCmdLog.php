<?php


namespace backend\models;


use backend\models\command\BaseCmd;
use backend\models\command\BaseSingleServerCmd;

class MyTabCmdLog extends TabCmdLog
{
    public function rules()
    {
        return [
            [['gameId', 'distributorId', 'type', 'cmdName', 'serverId'], 'required'],
            [['gameId', 'serverId', 'type', 'operator', 'status', 'distributorId', 'logTime'], 'integer'],
            [['cmdName', 'cmdInfo', 'result'], 'string', 'max' => 255],
        ];
    }

    public function doExecCmd()
    {
        if ($this->validate()) {
            $this->operator = \Yii::$app->user->id;
            $this->logTime = time();
            $cmdInfo = TabCmd::find()->where(['id' => $this->cmdName])->one();
            if (!empty($cmdInfo)) {
                $cmd = new BaseSingleServerCmd();
                $cmd->gameId = $this->gameId;
                $cmd->serverId = $this->serverId;
                $cmd->command = $cmdInfo['name'] . " " . $this->cmdInfo;
                $result = $cmd->execu();

                if (!empty($result)) {
                    $this->result = $result[0]['msg'];
                    $this->status = $result[0]['code'];

                } else {
                    $this->result = '执行GM命令出现异常';
                    $this->status = -1;
                }
                $this->save();
                return true;
            }
        }
        return false;
    }


}