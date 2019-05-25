<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-15
 * Time: 17:41
 */

namespace backend\models;
use yii\db\Expression;

class MyTabServers extends TabServers
{
    public static function searchGameServers($gameId,$distributionId)
    {
//        exit($gameId." ".$distributionId);
        self::openServer($gameId,$distributionId);
        $query=TabServers::find()
            ->select(['id','name','index','status','socket'=>'CONCAT_WS(":",url,netPort)'])
            ->where(['gameid'=>$gameId])
            ->where(new Expression('FIND_IN_SET(:distributions, distributions)'))
            ->addParams(['distributions'=>$distributionId])
            ->asArray();
        return $query->all();

    }
    public static function openServer($gameId,$distributionId)
    {
////        多值操作
//        $params=[$did.''];
//        $i=0;
//        $where=[];
//        foreach($params as $v){
//            $where[] = new Expression("FIND_IN_SET(:field_$i, field)",[":field_$i"=>$v]);
//        }
        TabServers::updateAll(
        //attributes
            ['status'=>1],
            //where
            ['and',
                ['gameId'=>$gameId],
                ['status'=>6],
                ['>=','openDateTime',date('Y-m-d H:i:i',time())],
                new Expression('FIND_IN_SET(:value, distributions)'),
            ],['value'=>$distributionId]);
    }
}