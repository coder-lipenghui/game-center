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
    public $loginKey;
    public $serverId;
    public $platformid;
    public $deviceId;
    public $loginip;
    public $token;

    public function rules()
    {
        return [
            [['loginKey','serverId','platformid','deviceId'],'required'],
            [['loginKey','deviceId'],'string'],
            [['platformid','serverid'],'integer'],
        ];
    }
}