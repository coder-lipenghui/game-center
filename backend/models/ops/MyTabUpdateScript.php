<?php


namespace backend\models\ops;

use backend\models\TabServers;
use common\helps\CurlHttpClient;

class MyTabUpdateScript extends TabUpdateScriptLog
{
    public function rules()
    {
        return [
            [['gameId', 'serverId', 'scriptName'], 'required'],
            [['gameId', 'serverId', 'logTime'], 'integer'],
            [['scriptName', 'operator'], 'string', 'max' => 255],
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
                $url="http://".$server->url."/api/script/update";
                $post['gameId']=$this->gameId;
                $post['port']=$server->contentPort;
                $post['file']=$this->scriptName;
//                exit(json_encode($post));
                $curl=new CurlHttpClient();
                $resultJson=$curl->sendPostData($url,$post,null,600);
                $result=json_decode($resultJson,true);
                $code=$result['code'];
                $msg=$result['msg'];
                if ($code==1)
                {
                    return json_encode(['id'=>$this->serverId,'code'=>1,'msg'=>'success']);
                }else{

                    return json_encode(['id'=>$this->serverId,'code'=>$code,'msg'=>$msg]);
                }
            }
        }else{
            return json_encode($this->getErrors());
        }
    }
}