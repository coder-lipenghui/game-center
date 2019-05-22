<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-22
 * Time: 09:49
 */

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class MyTabPermission extends TabPermission
{
    public function rules()
    {
        return [
            [['uid', 'gameId', 'distributorId', 'distributionId'], 'required'],
            [['uid', 'gameId', 'distributorId', 'distributionId'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
            [['distributionId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistribution::className(), 'targetAttribute' => ['distributionId' => 'id']],
            [['distributorId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistributor::className(), 'targetAttribute' => ['distributorId' => 'id']],
        ];
    }
    public static function getGames()
    {
        $query=TabPermission::find();
        $query->select(['id'=>'tab_permission.gameId','name'=>'tab_games.name'])
            ->join('LEFT JOIN','tab_games','tab_permission.gameId=tab_games.id')
            ->where(['uid'=>Yii::$app->user->id])->asArray();
        $data=$query->all();
        return ArrayHelper::map($data,'id','name');
    }
    public  function allowAccessGame()
    {
        $query=TabPermission::find();
        $query->select(['name','tab_games.id'])
            ->asArray()
            ->join('LEFT JOIN','tab_games','tab_games.id=tab_permission.gameId')
            ->where(['tab_permission.uid'=>Yii::$app->user->id]);

        $data=ArrayHelper::map($query->all(),'id','name');

        return $data;
    }
    public function allowAccessDistributor($gameId)
    {
        $query=TabPermission::find();
        $query->select('name,tab_distributor.id')
            ->join('LEFT JOIN','tab_distributor','tab_permission.distributorId=tab_distributor.id')
            ->where(['uid'=>Yii::$app->user->id,'gameId'=>$gameId])
            ->asArray();
        $data=$query->all();
        return $data;
    }
    public function allowAccessDistribution($gameId,$did,$uid)
    {
        $query=TabPermission::find();
        if ($gameId && $uid) {
            $query->select(['id'=>'tab_permission.distributionId', 'tab_distribution.distributorId', 'tab_distribution.platform'])
                ->join('LEFT JOIN', 'tab_distribution', 'tab_permission.distributionId=tab_distribution.id')
                ->where(['tab_permission.uid' => 1, 'tab_permission.gameId' => $gameId])
                ->andFilterWhere(['distributorId'=>$did])
                ->asArray();
            $data = $query->all();
            for ($i = 0; $i < count($data); $i++) {
                $distribution = $data[$i];
                $distributorQuery = TabDistributor::find()->where(['id' => (int)$distribution['distributorId']]);
                $tempData = $distributorQuery->one();
                if ($tempData != null) {
                    $data[$i]['name'] = $tempData->name;
                }
            }
            return $data;
        }
        return [];
    }
    public function allowAccessServer($gameId,$distributorId)
    {
        $distribution=TabPermission::find()->select(['distributionId'])->where(['uid'=>Yii::$app->user->id,'gameId'=>$gameId,'distributorId'=>$distributorId])->asArray()->all();
        if ($distribution)
        {
            $where=['or'];
            $i = 0;
            foreach($distribution as $v){
                $where[] = new Expression("FIND_IN_SET(:field_$i, distributions)",[":field_$i"=>$v['distributionId']]);
                $i++;
            }
            $query=TabServers::find()
                ->select(['name','id'])
                ->where(['gameId'=>$gameId])
                ->andWhere($where)
                ->asArray();
            $data=$query->all();
            return $data;
        }
        return [];
    }
}