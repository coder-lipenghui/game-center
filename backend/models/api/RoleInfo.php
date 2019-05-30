<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-16
 * Time: 15:50
 */
namespace backend\models\api;
use Yii;
use yii\base\Model;
use backend\models\TabGames;
use backend\models\TabDists;
use backend\models\TabPermission;
class RoleInfo extends BaseApiModel
{
    public $gameId;
    public $serverId;
    public $distributorId;//pt_flag

    /*API接口参数*/
    public $chrname;
    public $account="";
    public function rules()
    {
        $parentRules=parent::rules();
        $myRules= [
            [['chrname','account'],'string'],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabPermission::className(), 'targetAttribute' => ['gameId' => 'gameId']],
            [['distributorId'], 'exist', 'skipOnError' => true, 'targetClass' => TabPermission::className(), 'targetAttribute' => ['distributorId' => 'distributorId'],'filter'=>['uid'=>Yii::$app->user->id]],
        ];
        return array_merge($parentRules,$myRules);
    }

    public function attributeLabels()
    {
        return [
            'gameId' => Yii::t('app', '游戏'),
            'distributorId' => Yii::t('app', '平台'),
            'serverId' => Yii::t('app', '区服'),
            'chrname' => Yii::t('app', '角色名称'),
            'account' => Yii::t('app', '角色账号')
        ];
    }
}