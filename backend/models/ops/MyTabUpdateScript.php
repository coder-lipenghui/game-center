<?php


namespace backend\models\ops;

use backend\models\TabGames;
use backend\models\TabGameScript;
use backend\models\TabServers;
use common\helps\CurlHttpClient;

class MyTabUpdateScript extends TabUpdateScriptLog
{
    public function rules()
    {
        return [
            [['gameId', 'serverId', 'scriptName'], 'required'],
            [['gameId', 'serverId', 'status','operator', 'logTime'], 'integer'],
            [['scriptName', 'info'], 'string', 'max' => 255],
        ];
    }
    public function doUpdate()
    {
        $this->load(['MyTabUpdateScript'=>\Yii::$app->request->bodyParams]);
        if ($this->validate())
        {
            $server=TabServers::find()->where(['id'=>$this->serverId])->one();
            if (!empty($server))
            {
                $script=TabGameScript::find()->where(['gameId'=>$this->gameId,'fileName'=>$this->scriptName])->one();
                $game=TabGames::find()->where(['id'=>$server->gameId])->one();
                if (empty($script))
                {
                    return $this->returnResult(-102,$this->serverId,$server->name,$game->name,'unknown script');
                }else{
                    $url="http://".$server->url."/api/script/update";
                    $post['gameId']=$this->gameId;
                    $post['contentPort']=$server->contentPort;
                    $post['masterPort']=$server->masterPort;
                    $post['file']=$this->scriptName;
                    $post['md5']=$script->md5;
//                    return $this->returnResult(1,$this->serverId,$server->name,$game->name,'success');
                    if(1)
                    {
                        $curl=new CurlHttpClient();
                        $resultJson=$curl->sendPostData($url,$post,null,600);
                        $result=json_decode($resultJson,true);
                        if (!empty($result) && $result['code'])
                        {
                            $code=$result['code'];
                            $msg=$result['msg'];
                            $this->logTime=time();
                            $this->status=$code;
                            $this->info=$msg;
                            $this->operator=\Yii::$app->user->id;
                            $this->save();
                            if ($code==1)
                            {
                                return $this->returnResult(1,$this->serverId,$server->name,$game->name,'success');
                            }else{
                                return $this->returnResult($code,$this->serverId,$server->name,$game->name,$msg);
                            }
                        }else{
                            $code=-1;
                            $msg='更新异常';
                            $this->logTime=time();
                            $this->status=-1;
                            $this->info=$resultJson;
                            $this->operator=\Yii::$app->user->id;
                            $this->save();
                            return $this->returnResult(1,$this->serverId,$server->name,$game->name,$resultJson);
                        }
                    }
                }
            }else{
                return $this->returnResult(-101,$this->serverId,'','','unknown server');
            }
        }else{
            return $this->returnResult(-100,$this->serverId,'','','validate failed');
        }
    }
    private function returnResult($code,$id,$name,$game,$msg)
    {
        return json_encode(['id'=>$this->serverId,'game'=>$game,'name'=>$name,'code'=>$code,'msg'=>$msg]);
    }
}