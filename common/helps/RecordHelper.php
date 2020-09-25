<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-23
 * Time: 00:56
 */

namespace common\helps;


use backend\models\TabActionType;
use backend\models\TabGames;
use Yii;

class RecordHelper
{
    public static function getNameById($gameId,$id)
    {
        $cache=\Yii::$app->cache;
        $name=null;
        $key="src_".$gameId."_".$id;
        if($cache->get($key))
        {
            $name=$cache->get($key);
        }else{
            $versoin=TabGames::find()->select(['versionId'])->where(['id'=>$gameId])->one();
            $db=Yii::$app->get('db_log');
            $sql="select * from tab_src_$versoin->versionId where actionId=$id limit 1";
            $record=$db->createCommand($sql)->queryOne();
            try{
                $name=$record['actionName'];
                $cache->set($key,$name,36000);
            }catch (\Exception $e)
            {
//            return "未获取到物品名称";
            }
        }
        return $name;
    }
}