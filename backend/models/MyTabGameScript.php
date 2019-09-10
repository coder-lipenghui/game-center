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
            $dir=$dir."/".$this->fileName.".".$fileInfo->extension;
            if($fileInfo->saveAs($dir))
            {
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
    public function rocoard()
    {
        $this->userId=\Yii::$app->user->id;
        $this->logTime=time();
        return $this->save();
    }
}