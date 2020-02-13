<?php


namespace backend\models\ops;

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
                if (empty($script))
                {
                    return json_encode(['id'=>$this->serverId,'code'=>-102,'msg'=>'unknown script']);
                }else{
                    $url="http://".$server->url."/api/script/update";
                    $post['gameId']=$this->gameId;
                    $post['contentPort']=$server->contentPort;
                    $post['masterPort']=$server->masterPort;
                    $post['file']=$this->scriptName;
                    $post['md5']=$script->md5;

                    $curl=new CurlHttpClient();
                    $resultJson=$curl->sendPostData($url,$post,null,600);
                    $result=json_decode($resultJson,true);
                    $code=$result['code'];
                    $msg=$result['msg'];
                    $this->logTime=time();
                    $this->status=$code;
                    $this->info=$msg;
                    $this->operator=\Yii::$app->user->id;
                    $this->save();
                    if ($code==1)
                    {
                        return json_encode(['id'=>$this->serverId,'name'=>$server->name,'code'=>1,'msg'=>'success']);
                    }else{
                        return json_encode(['id'=>$this->serverId,'name'=>$server->name,'code'=>$code,'msg'=>$msg]);
                    }
                }
            }else{
                return json_encode(['id'=>$this->serverId,'name'=>'','code'=>-101,'msg'=>'unknown server ']);
            }
        }else{
            return json_encode(['id'=>$this->serverId,'name'=>'','code'=>-100,'msg'=>'validate failed']);
        }
    }
}