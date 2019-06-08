<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-06
 * Time: 18:00
 */

namespace backend\models;

use yii\data\ActiveDataProvider;

class MyCdkeySearch extends AutoCDKEYModel
{
    public function rules()
    {
        return [
            [['gameId', 'distributorId'], 'required'],
            [['gameId', 'distributorId', 'distributionId', 'varietyId', 'used', 'createTime'], 'integer'],
            [['cdkey'], 'string', 'max' => 100],
            [['varietyId'], 'exist', 'skipOnError' => true, 'targetClass' => TabCdkeyVariety::className(), 'targetAttribute' => ['varietyId' => 'id']],
        ];
    }

    public function search($param)
    {
        $query=MyCdkeySearch::find();
        $this->load($param);
        $query->where(['gameId'=>self::$gameId]);
        $query->andFilterWhere([
            'varietyId'=>$this->varietyId,
            'cdkey'=>$this->cdkey,
            'used'=>$this->used
        ]);
        $dataProvider=new ActiveDataProvider([
            'query'=>$query,
        ]);
        return $dataProvider;
    }
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }
}