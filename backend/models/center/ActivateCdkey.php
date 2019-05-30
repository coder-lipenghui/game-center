<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-29
 * Time: 11:17
 */

namespace backend\models\center;

use backend\models\TabCdkeyRecord;
use backend\models\TabDistribution;
use backend\models\TabGames;
use backend\models\TabServers;
class ActivateCdkey extends TabCdkeyRecord
{
    public $sku;

    public function rules()
    {
        return [
            [['sku', 'distributionId','serverId', 'account', 'roleId', 'roleName', 'cdkey'], 'required'],
            [['distributionId', 'logTime','serverId'], 'integer'],
            [['account', 'roleId', 'roleName', 'cdkey','sku'], 'string', 'max' => 100],
            [['distributionId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistribution::className(), 'targetAttribute' => ['distributionId' => 'id']],
//            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
            [['serverId'], 'exist', 'skipOnError' => true, 'targetClass' => TabServers::className(), 'targetAttribute' => ['serverId' => 'id']],
        ];
    }
}