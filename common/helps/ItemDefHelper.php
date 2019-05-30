<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-22
 * Time: 23:55
 */

namespace common\helps;
use backend\models\TabItemdef;
use backend\models\TabItemdefDzy;
use yii\helpers\ArrayHelper;

class ItemDefHelper
{
    /**
     * 根据物品ID获取物品名称
     * @param $gameid 游戏名称
     * @param $itemid 物品id
     */
    public static function getNameById($gameid,$id)
    {
        $itemdef=TabItemdefDzy::find()->where(['id'=>$id])->asArray()->one();
        $name=null;
        try{

            $name=$itemdef['name'];
        }catch (\Exception $e)
        {
//            return "未获取到物品名称";
        }
        return $name;
    }
    public static function getIdByName($gameid,$name)
    {
        $itemdef=TabItemdefDzy::find()->where(['name'=>$name])->asArray()->one();
        $id=null;
        try{
           $id=$itemdef['id'];
        }catch (\Exception $e)
        {

        }
        return $id;
    }
    public static function getItemInfoById($gameid,$id)
    {
        //TODO 将查询的结果按照 itemid:[id,name,xxx]的形式存cookie
        $itemdef=TabItemdefDzy::find()->select(['id','name','icon_id','res_id','description'])->where(['id'=>$id])->asArray()->one();
        return $itemdef;
    }
}