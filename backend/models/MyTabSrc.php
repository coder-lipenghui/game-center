<?php


namespace backend\models;


use Yii;
use yii\web\UploadedFile;

class MyTabSrc extends TabSrc
{
    protected static $version;
    public $file;
    public $versionId;

    private $fileName;
    private $fileSize;

    public static function TabSuffix($id)
    {
        self::$version=$id;
    }
    public static function tableName()
    {
        $originalName=parent::tableName();
        if (self::$version)
        {
            return $originalName.'_'.self::$version;
        }
        return $originalName;
    }

    public function rules()
    {
        $myRules= [
            [['versionId','file'],'required'],
            [['versionId'],'integer'],
            [['file'],'file','skipOnError'=>false,'extensions'=>'lua','maxSize'=>5242880],
        ];
        return $myRules;
    }
    public function uploadSrc()
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
            $dir="../web/uploads/data";
            if (!is_dir($dir))
            {
                mkdir($dir);
            }
            $dir=$dir."/".$this->fileName.".".$fileInfo->extension;
            if($fileInfo->saveAs($dir))
            {
                $file = fopen($dir,'r');
                $i=1;
                $fields=[];
                $types=[];
                $comments=[];

                $values=[];
                while (!feof($file))
                {
                    $list=fgets($file);//fgets()函数从文件指针中读取一行
                    $info=mb_split("=",trim($list));

                    if (count($info)<2)
                    {
                        continue;
                    }
                    $actionName="";
                    $actionLua=$info[0];
                    if ($info[1])
                    {
                        $secondInfo=mb_split("--",$info[1]);
                        $actionId=trim($secondInfo[0]);
                        if (!empty($secondInfo[1]))
                        {
                            $actionName=trim(preg_replace("/-/","",$secondInfo[1]));
                        }else{
                            $actionName=$actionLua;
                        }
                        $actionType=strpos($actionLua,"ADD")?1:2;
                        array_push($values,[$i,$actionId,$actionType,$actionName,$actionName,$actionLua]);
                        $i++;
                    }
                }
                fclose($file);
                //批量插入数据
                if (count($values)>0){
                    //清空表
                    $sql="
                    DROP TABLE IF EXISTS `tab_src_".$this->versionId."`;
                    CREATE TABLE `tab_src_".$this->versionId."` (
                      `id` int(20) NOT NULL AUTO_INCREMENT,
                      `actionId` int(10) DEFAULT NULL COMMENT '日志编号',
                      `actionType` int(2) DEFAULT NULL COMMENT '日志类型:增加、移除',
                      `actionName` varchar(255) DEFAULT NULL COMMENT '日志名称',
                      `actionDesp` varchar(255) DEFAULT NULL COMMENT '日志描述',
                      `actionLua` varchar(255) DEFAULT NULL COMMENT 'lua变量',
                      PRIMARY KEY (`id`) USING BTREE
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
                    
                    SET FOREIGN_KEY_CHECKS = 1;
                    ";
                    $query=Yii::$app->get('db_log')->createCommand($sql);
                    $query->execute();
                    $query->pdoStatement->closeCursor();
                    //重新插入数据
                    $db=Yii::$app->get('db_log');
                    $cmd=$db->createCommand();
                    $cmd->batchInsert("tab_src_".$this->versionId,$fields,$values);
                    $cmd->query();

                    return true;
                }
            }else{
                echo(json_encode($this->getErrors()));
                return false;
            }
        }
        return true;
    }

    /**
     * @param $type 1获取或者2移除
     */
    function getSrcByType($type)
    {
        $query=self::find()->select(['id'=>'actionId','name'=>'actionName'])->where(['actionType'=>$type])->asArray();
//        exit($query->createCommand()->getRawSql());
        $result=$query->all();

        return $result;
    }
}