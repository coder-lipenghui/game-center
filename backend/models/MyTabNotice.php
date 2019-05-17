<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-17
 * Time: 10:57
 */

namespace backend\models;


class MyTabNotice extends TabNotice
{
    public static function searchGameNotice($gameid,$did)
    {
        $time=time();
        $query=TabNotice::find();
        $query->where(['gameid'=>$gameid,'id'=>1])//,'did'=>$did
        ->andWhere(['>=','starttime',$time])
            ->andWhere(['<=','endtime',$time])
            ->orderBy('rank DESC')
            ->asArray();
//        exit($query->createCommand()->getRawSql());
        return $query->all();
    }
}