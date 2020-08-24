<?php

namespace backend\models;

use backend\models\TabCdkeyVariety;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * TabCdkeyVarietySearch represents the model behind the search form of `backend\models\TabCdkeyVariety`.
 */
class TabCdkeyVarietySearch extends TabCdkeyVariety
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'once'], 'integer'],
            [['name', 'items'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TabCdkeyVariety::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gameId' => $this->gameId,
            'once' => $this->once,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'items', $this->items]);

        return $dataProvider;
    }
    public function searchByGameId($params)
    {
        $query = TabCdkeyVariety::find();

        if (empty($params['gameId']))
        {
            return ['code'=>'-1','msg'=>'参数不正确'];
        }


        // grid filtering conditions
        $data=$query->select(['id','name'])->where([
            'gameId' => $params['gameId'],
        ])
            ->orderBy('name')
            ->asArray()
            ->all();

        return $data;
    }
}
