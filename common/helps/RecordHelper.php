<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-23
 * Time: 00:56
 */

namespace common\helps;


use backend\models\TabActionLog;

class RecordHelper
{
    public static function getNameById($gameid,$id)
    {
        $record=TabActionLog::find()->where(['actionId'=>$id])->asArray()->one();
        $name=null;
        try{
            $name=$record['actionName'];
        }catch (\Exception $e)
        {

        }
        return $name;
    }
}