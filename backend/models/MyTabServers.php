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
    public static function searchGameServers($gameId,$distributoin,$distributionUserId,$ip){

        self::openServer($gameId,$distributoin->distributorId);
        $filter=[];
        if (!empty($distributionUserId))
        {
            $whiteQuery=TabWhitelist::find();
            $whiteQuery->where(['or',"ip='$ip'","distributionUserId='$distributionUserId'"]);
            $list=$whiteQuery->all();
            if (empty($list))
            {
                $filter=['<=','openDateTime',date('Y-m-d H:i:s',time())];
            }else{
                $filter=[];
            }
        }
        $query=TabServers::find()
            ->select(['id','name','index','status','mergeId','socket'=>'CONCAT_WS(":",url,netPort)'])
            ->where(['gameId'=>$gameId,'distributorId'=>$distributoin->distributorId])
            ->andWhere($filter)
            ->asArray();
        $servers=$query->all();
        //处理合区数据
        $mainServers=[];//100个区合到一个区的时候，减少查询次数
        for ($i=0;$i<count($servers);$i++)
        {
            if (!empty($servers[$i]['mergeId']))
            {
                $mergeId=$servers[$i]['mergeId'];
                $server=null;
                if (!empty($mainServers[$mergeId]))
                {
                    $server=$mainServers[$mergeId];
                }else{
                    $server=TabServers::find()->where(['id'=>$mergeId])->one();
                    if (!empty($server))
                    {
                        $mainServers[$mergeId]=$server;
                    }
                }
                if (!empty($server))
                {
                    $servers[$i]['socket']=$server->url.":".$server->netPort;
                    unset($servers[$i]['mergeId']);
                }
            }
        }
        return $servers;
    }
    public static function openServer($gameId,$distributorId)
    {
        TabServers::updateAll(
            ['status'=>1],
            ['and',
                ['gameId'=>$gameId],
                ['distributorId'=>$distributorId],
                ['status'=>6],
                ['>=','openDateTime',date('Y-m-d H:i:s',time())],
            ]);
    }
    public static function getServersByGameId($gameId)
    {
        return self::find()->where(['gameId'=>$gameId])->asArray()->all();
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