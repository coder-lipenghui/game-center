<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-21
 * Time: 10:13
 */

namespace backend\models\api;
use Yii;
use yii\base\Model;

class BaseApiModel extends Model
{
    public $gameId;
    public $serverId;
    public $distributorId;
    /**角色名称*/
    public $playerName;
    /**角色账号，中控后台分配*/
    public $playerAccount;

    public $from;
    public $to;

    public function attributeLabels()
    {
        return [
            'gameId' => Yii::t('app', '游戏'),
            'distributorId'=>Yii::t('app','分销商'),
            'serverId' => Yii::t('app', '区服'),
            'playerName'=>Yii::t('app','角色名称'),
            'playerAccount'=>Yii::t('app','角色账号'),
            'from' => Yii::t('app', '开始时间'),
            'to' => Yii::t('app', '结束时间'),
        ];
    }
    public function rules()
    {
        return [
            [['gameId','distributorId','serverId'],'required'],
            [['gameId', 'serverId','distributorId'], 'integer'],
            [['playerName','playerAccount'],'string'],
            [['from', 'to'], 'date','format'=>'yyyy-MM-dd HH:mm:ss'],
        ];
    }
}