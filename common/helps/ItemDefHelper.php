<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-22
 * Time: 23:55
 */

namespace common\helps;
use backend\models\TabGames;
use backend\models\TabItemdefDzy;
use Yii;
use yii\db\Exception;

class ItemDefHelper
{
    /**
     * 根据物品ID获取物品名称
     * @param $gameid 游戏名称
     * @param $itemid 物品id
     */
    public static function getNameById($gameId,$id)
    {
        $cache=\Yii::$app->cache;
        $key="item_".$gameId."_".$id;
        $name=null;
        if($cache->get($key))
        {
            $name=$cache->get($key);
        }else{
            $game=TabGames::find()->select(['versionId'])->where(['id'=>$gameId])->one();
            $db=Yii::$app->get('db_log');
            $sql="select * from tab_itemdef_".$game->versionId." where id=$id limit 1";
            $itemdef=$db->createCommand($sql)->queryOne();
            try{
                $name=$itemdef['name'];
                $cache->set($key,$name,3600);
            }catch (\Exception $e)
            {
//            return "未获取到物品名称";
            }
        }
        return $name;
    }
    public static function getIdByName($gameId,$name)
    {
        $db=Yii::$app->get('db_log');
        $id=null;
        try{
            $game=TabGames::find()->where(['id'=>$gameId])->one();
            $sql="select * from tab_itemdef_".$game->versionId." where `name`='$name' limit 1";
            $itemdef=$db->createCommand($sql)->queryOne();
            $id=$itemdef['id'];
        }catch (\Exception $e)
        {

        }
        return $id;
    }
    public static function getNameByVersion($version,$id)
    {
        $cache=\Yii::$app->cache;
        $key="item_".$version."_".$id;
        $name=$id;
        if($cache->get($key)) {
            $name = $cache->get($key);
        }else{
            $db=Yii::$app->get('db_log');
            $sql="select * from tab_itemdef_".$version." where id=(".$id.") limit 1";
            $itemdef=$db->createCommand($sql)->queryOne();
            try{
                $name=$itemdef['name'];
                $cache->set($key,$name,3600);
            }catch (\Exception $e)
            {
            }
        }
        return $name;
    }
    public static function getIdByVersion($version,$name)
    {
        $cache=\Yii::$app->cache;
        $key="item_".$version."_".$name;
        $id=$name;
        if($cache->get($key)) {
            $name = $cache->get($key);
        }else {
            $db = Yii::$app->get('db_log');
            $sql = "select * from tab_itemdef_" . $version . " where `name`=($name) limit 1";
            $itemdef = $db->createCommand($sql)->queryOne();
            try {
                $id = $itemdef['id'];
                $cache->set($key,$id,3600);
            } catch (\Exception $e) {
            }
        }
        return $id;
    }

    public static function getItemInfoById($gameId,$id)
    {
        $db=Yii::$app->get('db_log');
        $sql="select * from tab_itemdef_$gameId where id=($id) limit 1";
        $itemdef=$db->createCommand($sql)->queryOne();
        return $itemdef;
    }
    public static function getAllItem($versionId)
    {
        $db=Yii::$app->get('db_log');
        $items=[];
        $sql="select id,name from tab_itemdef_$versionId";
        try {
            $items=$db->createCommand($sql)->query();
        }catch (Exception $e)
        {

        }
        return $items;
    }
}