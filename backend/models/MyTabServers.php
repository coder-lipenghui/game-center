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
        self::openServer($gameId,$distributionId);
        $query=TabServers::find()
            ->select(['id','name','index','status','socket'=>'CONCAT_WS(":",url,netPort)'])
            ->where(['gameid'=>$gameId])
            ->andWhere(['<=','openDateTime',date('Y-m-d H:i:s',time())])
            ->andWhere(new Expression('FIND_IN_SET(:distributions, distributions)'))
            ->addParams(['distributions'=>$distributionId])
            ->asArray();
        return $query->all();

    }
    public static function openServer($gameId,$distributionId)
    {
        TabServers::updateAll(
        //attributes
            ['status'=>1],
            //where
            ['and',
                ['gameId'=>$gameId],
                ['status'=>6],
                ['>=','openDateTime',date('Y-m-d H:i:s',time())],
                new Expression('FIND_IN_SET(:value, distributions)'),
            ],['value'=>$distributionId]);
    }
    public static function todayOpen()
    {
        $cond=['between','openDateTime',strtotime(date('Y-m-d')." 00:00:00"),strtotime(date('Y-m-d')."23:59:59")];
        $query=TabServers::find()
            ->asArray()
            ->where($cond);

        $todayOpen=$query->count('*');
        $todayOpen=$todayOpen?$todayOpen:0;

        return $todayOpen;
    }
}