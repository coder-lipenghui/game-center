<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-17
 * Time: 10:57
 */

namespace backend\models;


use yii\db\Expression;

class MyTabNotice extends TabNotice
{
    public $rank=0;
    public function rules()
    {
        return [
            [['gameId', 'distributions', 'title', 'body', 'starttime', 'endtime'], 'required'],
            [['gameId', 'rank'], 'integer'],
            [['starttime'],'filter','filter'=>function(){
                return strtotime($this->starttime);
            }],
            [['endtime'],'filter','filter'=>function(){
                return strtotime($this->endtime);
            }],
            [['body'], 'string'],
            [['distributions'],'filter','filter'=>function(){
                return  join(",",$this->distributions);
            }],
            [['title'], 'string', 'max' => 255],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
        ];
    }

    public static function searchGameNotice($gameid,$did)
    {
        $time=time();
        $query=TabNotice::find();
        $query->where(['gameid'=>$gameid])
            ->where(new Expression('FIND_IN_SET(:distributions, distributions)'))
            ->addParams(['distributions'=>$did])
             ->andWhere(['<=','starttime',$time])
            ->andWhere(['>=','endtime',$time])
            ->orderBy('rank DESC')
            ->asArray();
        //exit($query->createCommand()->getRawSql());
        return $query->all();
    }
}