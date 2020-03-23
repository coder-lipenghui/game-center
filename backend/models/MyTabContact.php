<?php


namespace backend\models;


use backend\models\report\ModelRoleLog;

class MyTabContact extends TabContact
{
    public static $gid;
    public static $did;
    public $sku;
    public static function TabSuffix($gid,$did)
    {
        self::$gid=$gid;
        self::$did=$did;
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
    public function rules()
    {
        $myRules=[
            [['sku','activeAccount','activeRoleId', 'passivityRoleId', 'serverId'], 'required'],
            [['activeAccount','sku','activeRoleId', 'passivityAccount', 'passivityRoleId'], 'string', 'max' => 255],
        ];
        return $myRules;
    }
    public function doBind()
    {
        if ($this->validate())
        {
            $game=TabGames::find()->where(['sku'=>$this->sku])->one();
            if (!empty($game))
            {
                $server=TabServers::find()->where(['id'=>$this->serverId])->one();
                if (!empty($server))
                {
                    $role=new ModelRoleLog();
                    $role::TabSuffix(self::$gid,self::$did);
                    $playerQuery=$role::find()->where(['roleId'=>$this->activeRoleId,'serverId'=>$this->serverId,'gameId'=>$game->id]);
                    $player=$playerQuery->one();
                    $target=$role::find()->where(['roleId'=>$this->passivityRoleId,'serverId'=>$this->serverId,'gameId'=>$game->id])->one();
                    if (!empty($player))
                    {
                        if (!empty($target))
                        {
                            $contact=self::find()->where(['activeRoleId'=>$this->activeRoleId])->one();
                            if (!empty($contact))
                            {
                                if ($contact['passivityRoleId']!=$this->passivityRoleId)
                                {
                                    $contact['passivityRoleId']=$this->passivityRoleId;
                                    if($contact->update(false))
                                    {
                                        return ['code'=>1,'msg'=>'修改成功'];
                                    }else{
                                        return ['code'=>-5,'msg'=>'修改失败','data'=>$contact->getErrors()];
                                    }
                                }else{
                                    return ['code'=>1,'msg'=>'未做修改'];
                                }
                            }else{
                                $this->passivityAccount=$target->account;
                                $this->logTime=time();
                                if($this->save())
                                {
                                    return ['code'=>1,'msg'=>'关联成功'];
                                }else{
                                    return ['code'=>-5,'msg'=>'关联失败'];
                                }
                            }
                        }else{
                            return ['code'=>-4,'msg'=>'关联账号不存在'];
                        }
                    }else{
                        return ['code'=>-3,'msg'=>'账号异常','data'=>$playerQuery->createCommand()->getRawSql()];
                    }
                }else{
                    return ['code'=>-2,'msg'=>'未知区服'];
                }
            }else{
                return ['code'=>-1,'msg'=>'未知游戏'];
            }
        }else{
            return ['code'=>-1,'msg'=>'参数错误','data'=>$this->getErrors()];
        }
    }
}