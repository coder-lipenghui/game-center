<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-23
 * Time: 00:56
 */

namespace common\helps;


use backend\models\TabActionType;

class RecordHelper
{
    public static function getNameById($gameId,$id)
    {
        $record=TabActionType::find()->where(['actionId'=>$id])->asArray()->one();
        $name=null;
        try{
            $name=$record['actionName'];
        }catch (\Exception $e)
        {

        }
        return $name;
    }
}