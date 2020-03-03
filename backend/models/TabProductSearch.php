<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabProduct;

/**
 * TabProductSearch represents the model behind the search form of `backend\models\TabProduct`.
 */
class TabProductSearch extends TabProduct
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'type', 'productId', 'productPrice', 'enable'], 'integer'],
            [['productName', 'productScript'], 'safe'],
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
        $query = TabProduct::find();

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
            'type' => $this->type,
            'productId' => $this->productId,
            'productPrice' => $this->productPrice,
            'enable' => $this->enable,
        ]);

        $query->andFilterWhere(['like', 'productName', $this->productName])
            ->andFilterWhere(['like', 'productScript', $this->productScript]);

        return $dataProvider;
    }
}
