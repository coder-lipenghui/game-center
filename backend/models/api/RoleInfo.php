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
class RoleInfo extends Model
{
    public $gameid;
    public $serverid;
    public $pid;//pt_flag

    /*API接口参数*/
    public $chrname;
    public $account="";
    public function rules()
    {
        return [
            [['gameid','pid','serverid'],'required'],
            [['gameid', 'serverid'], 'integer'],
            [['pid','chrname','account'],'string'],
            [['gameid'], 'exist', 'skipOnError' => true, 'targetClass' => TabPermission::className(), 'targetAttribute' => ['gameid' => 'gid']],
            [['pid'], 'exist', 'skipOnError' => true, 'targetClass' => TabPermission::className(), 'targetAttribute' => ['pid' => 'pid'],'filter'=>['uid'=>Yii::$app->user->id]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'gameid' => Yii::t('app', '游戏'),
            'pid' => Yii::t('app', '平台'),
            'serverid' => Yii::t('app', '区服'),
            'chrname' => Yii::t('app', '角色名称'),
            'account' => Yii::t('app', '角色账号')
        ];
    }
}