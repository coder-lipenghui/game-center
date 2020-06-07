<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabCdn;

/**
 * TabCdnSearch represents the model behind the search form of `backend\models\TabCdn`.
 */
class TabCdnSearch extends TabCdn
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId'], 'integer'],
            [['updateUrl', 'assetsUrl', 'platform', 'secretId', 'secretKey', 'comment'], 'safe'],
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
        $query = TabCdn::find();

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
        ]);

        $query->andFilterWhere(['like', 'updateUrl', $this->updateUrl])
            ->andFilterWhere(['like', 'assetsUrl', $this->assetsUrl])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'secretId', $this->secretId])
            ->andFilterWhere(['like', 'secretKey', $this->secretKey])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
