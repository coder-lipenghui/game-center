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
    public $accountId;
    public $dist;
    public $versionCode;
    public $versionName;
    public function rules()
    {
        return [
            [['deviceOs', 'deviceVender', 'deviceId', 'deviceType','token','accountId','sku','dist','versionCode','versionName'], 'required'],
            [['gameid', 'playerId','dist'], 'integer'],
            [['sku','accountId','versionCode','versionName'],'string'],
//            [['timestamp'], 'safe'],
            [['distributor'], 'string', 'max' => 255],
            [['ipAddress', 'deviceOs', 'deviceVender', 'deviceType'], 'string', 'max' => 45],
            [['deviceId'], 'string', 'max' => 50],
            [['loginKey'], 'string', 'max' => 100],
            [['token'], 'string', 'max' => 512],
        ];
    }
}