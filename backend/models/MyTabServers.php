<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-15
 * Time: 17:41
 */

namespace backend\models;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class MyTabServers extends TabServers
{
    public static function searchGameServers($game,$distributoin,$distributionUserId,$ip)
    {
        self::openServer($game->id,$distributoin->distributorId);
        $filter=[];
        if (!empty($distributionUserId))
        {
            $whiteQuery=TabWhitelist::find();
            $whiteQuery->where(['or',"ip='$ip'","distributionUserId='$distributionUserId'"]);
            $list=$whiteQuery->asArray()->all();
            if (count($list)==0)
            {
                $filter=['<=','openDateTime',date('Y-m-d H:i:s',time())];
            }else{
                $filter=[];
            }
        }
        //当前为测试渠道、或者在白名单内则同时拉取
        $testServers=[];
        if ($distributoin->isDebug || count($filter)==0)
        {
            $query=TabDebugServers::find()
                ->select(['id','name','index','status','mergeId','socket'=>'CONCAT_WS(":",url,netPort)'])
                ->where(['versionId'=>$game->versionId])
                ->andWhere($filter)
                ->asArray();
            $testServers=$query->all();
        }
        #区服冠名信息
        $serverNames=TabServerNaming::find()->select(['serverId','naming'])->where(['gameId'=>$game->id,'distributorId'=>$distributoin->distributorId])->asArray()->all();
        if (!empty($serverNames))
        {
            $serverNames=ArrayHelper::index($serverNames,'serverId');
        }
        //混服模式区服
        $mingleServerId=$distributoin->mingleServerId;
        if (!empty($distributoin->mingleDistributionId))
        {
            $tmp=TabDistribution::find()->where(['id'=>$distributoin->mingleDistributionId])->one();
            if (!empty($tmp))
            {
                $distributoin=$tmp;
            }
        }
        $query=TabServers::find()
            ->select(['id','name','index','status','mergeId','socket'=>'CONCAT_WS(":",url,netPort)'])
            ->where(['gameId'=>$distributoin->gameId,'distributorId'=>$distributoin->distributorId])
            ->andWhere($filter)
            ->asArray();
        if (!empty($mingleServerId) && $mingleServerId>0)
        {
            $query->andWhere(['>=','index',$mingleServerId]);
        }
        $servers=$query->all();
        //展示未开的首服
        if (empty($servers))
        {
            $tmpQuery=TabServers::find()
                ->select(['id','name','index','status','mergeId','socket'=>'CONCAT_WS(":",url,netPort)'])
                ->where(['>=','openDateTime',date('Y-m-d H:i:s',time())])
                ->andWhere(['gameId'=>$distributoin->gameId,'distributorId'=>$distributoin->distributorId])
                ->asArray()
                ->limit(1);
            $servers=$tmpQuery->all();
        }
        //处理合区数据
        $mainServers=[];//100个区合到一个区的时候，减少查询次数
        for ($i=0;$i<count($servers);$i++)
        {
            if ($mingleServerId>0)
            {
                $servers[$i]['index']=($servers[$i]['index']-$mingleServerId+1)."";
                $servers[$i]['name']=$servers[$i]['index']."区";
            }
            if ($serverNames && !empty($serverNames[$servers[$i]['id']]))
            {
                $servers[$i]['name']=$serverNames[$servers[$i]['id']]['naming'];
            }
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
        return array_merge($testServers,$servers);
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

    /**
     *
     * @param $gameId
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getServersByGameId($gameId)
    {

        $query=self::find()
            ->select([
                "name"=>"tab_games.name",
                "serverName"=>"tab_servers.name",
                "id"=>"tab_servers.id",
                "index"=>"tab_servers.index",
                "port"=>"tab_servers.netPort",
                "url"=>"tab_servers.url",
            ])
            ->where([
                'gameId'=>$gameId,
                'mergeId'=>null,
            ])->join("LEFT JOIN","tab_games","tab_games.id=tab_servers.gameId")
            ->groupBy(['url'])
            ->asArray();
        $game=TabGames::find()->where(['id'=>$gameId])->one();
        $servers=$query->all();
        $testServers=[];
        if (!empty($game))
        {
            $testServers=TabDebugServers::find()
                ->select(['serverName'=>'name','id','index','port'=>'netPort','url'])
                ->where(['versionId'=>$game->versionId])->asArray()->all();
            foreach ($testServers as $k=>$v)
            {
                $testServers[$k]['name']='测试';
            }
        }
        return array_merge($testServers,$servers);
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