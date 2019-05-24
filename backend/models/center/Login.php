<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-08
 * Time: 10:47
 */
namespace backend\models\center;
use backend\models\TabLogLogin;
//use yii\base\Model;

class Login extends TabLogLogin
{
    public $sku;
    public $uid;
    public $distributionId;
    public $versionCode;
    public $versionName;
    public function rules()
    {
        return [
            [['token','sku','uid','distributionId'], 'required'],
            [['gameId', 'distributionId', 'playerId'], 'integer'],
            [['loginTime'], 'safe'],
            [['ip', 'deviceOs', 'deviceVender', 'deviceType','versionCode','versionName','uid','sku'], 'string', 'max' => 45],
            [['deviceId'], 'string', 'max' => 50],
            [['loginKey'], 'string', 'max' => 100],
            [['token'], 'string', 'max' => 512],
        ];
    }
}