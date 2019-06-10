<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-10
 * Time: 18:31
 */

namespace backend\models;


class MyTabPlayers extends TabPlayers
{
    public static function numberGroupByDistributor()
    {
        $query=self::find()
            ->select(['distributorId','value'=>'count(account)'])
            ->join('LEFT JOIN','tab_distribution','tab_players.distributionId=tab_distribution.id')
            ->groupBy(['distributorId'])
            ->asArray();
        $data=$query->all();

        for ($i=0;$i<count($data);$i++)
        {
            $distributor=TabDistributor::find()->where(['id'=>(int)$data[$i]['distributorId']])->one();
            if ($distributor)
            {
                $data[$i]['name']=$distributor->name;
                unset($data[$i]['distributorId']);
            }
        }
        return $data;
    }
    public static function todayRegister()
    {
//        $cond=['between','payTime',strtotime(date('Y-m-d')." 00:00:00"),strtotime(date('Y-m-d')."23:59:59")];

        $query=self::find()
            ->where(['like','regTime',date('Y-m-d')]);
        $data=$query->count();

        return $data;
    }
}