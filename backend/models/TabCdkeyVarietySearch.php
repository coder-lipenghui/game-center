<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabCdkeyVariety;

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
            [['id', 'once'], 'integer'],
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
            'once' => $this->once,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'items', $this->items]);

        return $dataProvider;
    }
}
