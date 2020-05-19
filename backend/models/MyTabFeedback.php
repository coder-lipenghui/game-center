<?php


namespace backend\models;


use backend\models\report\ModelRoleLog;
use common\helps\CurlHttpClient;

class MyTabFeedback extends TabFeedback
{
    public static $gid;
    public static $did;
    public $sku;
    public static function TabSuffix($gid,$did)
    {
        self::$gid=$gid;
        self::$did=$did;
    }
    public function rules()
    {
        $myRule= [
            [['sku'], 'required'],
            [['sku'], 'string', 'max' => 255]
        ];
        return array_merge(parent::rules(),$myRule);
    }

    public static function tableName()
    {
        $originalName=parent::tableName();
        if (self::$gid && self::$did)
        {
            return $originalName.'_'.self::$gid.'_'.self::$did;
        }
        return $originalName;
    }
    public function feedback()
    {
        if (!$this->validate()){return ['code'=>-1,'msg'=>'参数错误','data'=>$this->getErrors()];}

        $game=TabGames::find()->where(['sku'=>$this->sku])->one();
        if (empty($game)){return ['code'=>-2,'msg'=>'未知游戏'];}

        $server=TabServers::find()->where(['id'=>$this->serverId])->one();
        if (empty($server)){return ['code'=>-3,'msg'=>'未知区服'];}

        $role=new ModelRoleLog();
        $role::TabSuffix(self::$gid,self::$did);
        $playerQuery=$role::find()->where(['roleId'=>$this->roleId,'serverId'=>$this->serverId,'gameId'=>$game->id]);
        $player=$playerQuery->one();

        if (empty($player)){return ['code'=>-4,'msg'=>'账号异常','data'=>$playerQuery->createCommand()->getRawSql()];}

        if (!$this->save())
        {
            return ['code'=>-5,'msg'=>'提交失败','data'=>$playerQuery->createCommand()->getRawSql()];
        }
        $this->webhook($this->title,$this->content);
        return ['code'=>1,'msg'=>'提交成功','data'=>[]];
    }
    private function webhook()
    {
        $curlhttp=new CurlHttpClient();
        $url="https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=b129b49b-c2c2-4874-9aa0-8e91e95b3df0";
        $content=[
            'msgtype'=>'text',
            'text'=>[
                'content'=>"朵啊，玩家提意见了:\n标题:$this->title.\n内容:\n$this->content.\n来自玩家:$this->roleName",
                'mentioned_list'=>['wuduo']
            ]
        ];
        $curlhttp->sendPostJsonData($url,$content);
    }
}