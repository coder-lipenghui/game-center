<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-09
 * Time: 10:41
 */

namespace backend\models\center;


use yii\base\Model;

class EnterGame extends Model
{
    public $serverId;
    public $deviceId;
    public $token;

    public function rules()
    {
        return [
            [['token','serverId','deviceId'],'required'],
            [['token','deviceId'],'string'],
            [['serverId'],'integer'],
        ];
    }
}