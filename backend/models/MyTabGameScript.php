<?php


namespace backend\models;

use yii\web\UploadedFile;

class MyTabGameScript extends TabGameScript
{
    public $file;
    public function rules()
    {
        return [
            [['gameId','comment'], 'required'],
            [['gameId', 'userId', 'logTime'], 'integer'],
            [['file'],'file','skipOnError'=>false,'extensions'=>'7z,zip,rar','maxSize'=>5242880],
            [['fileSize'], 'number'],
            [['fileName', 'comment'], 'string', 'max' => 255],
        ];
    }
    public function uploadZip()
    {
        //------脚本热更新操作------
        //1.存储文件按照游戏ID_分销商ID_test/release存放，并记录上传日志
        //2.将文件curl到目标服务器
        //3.目标服务器存储目录同1
        //4.调用contentSender.exe 向目标服务器发送脚本名称
        //5.通过后台调用"lscript"至目标服务器完成脚本更新

        //------服务器重启更新操作------
        //1.同步最新的script文件
        //2.同步最新的gameserver.exe文件
        //3.同步最新的mapo文件
        //4.重启gameserver.exe
        //5.发送脚本


        $request=\Yii::$app->request;
        if ($this->load($request->bodyParams))
        {
            $fileInfo=UploadedFile::getInstance($this,'file');
            if ($fileInfo)
            {
                $this->fileName=$fileInfo->name;
                $this->fileSize=$fileInfo->size/1024;
            }else{
                echo("文件不存在");
                return false;
            }


            $dir="../web/uploads";
            if (!is_dir($dir))
            {
                mkdir($dir);
            }
            $dir="../web/uploads/script";
            if (!is_dir($dir))
            {
                mkdir($dir);
            }
            $dir=$dir."/".$this->gameId;
            if (!is_dir($dir))
            {
                mkdir($dir);
            }
            $dir=$dir."/".$this->fileName;
            if($fileInfo->saveAs($dir))
            {
                $this->md5=md5_file($dir);
                if(!$this->rocoard())
                {
                    echo(json_encode($this->getErrors()));
                    return false;
                }else{

                    return true;
                }
            }else{
                echo(json_encode($this->getErrors()));
                return false;
            }

        }
        return false;
    }
    public function post2server()
    {
        $url="";
        $post_data = array(
            "file" => "@/uploads/"
        );
        $ch = curl_init();
        curl_setopt($ch , CURLOPT_URL , $url);
        curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch , CURLOPT_POST, 1);
        curl_setopt($ch , CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);
    }
    public function rocoard()
    {
        $this->userId=\Yii::$app->user->id;
        $this->logTime=time();
        return $this->save();
    }
    public function updateScript()
    {

    }
}