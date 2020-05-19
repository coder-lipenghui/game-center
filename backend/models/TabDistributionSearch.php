<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MyTabDistribution;

/**
 * TabDistributionSearch represents the model behind the search form of `backend\models\TabDistribution`.
 */
class TabDistributionSearch extends TabDistribution
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'distributorId', 'parentDT', 'enabled', 'isDebug'], 'integer'],
            [['platform', 'centerLoginKey', 'centerPaymentKey', 'appID', 'appKey', 'appLoginKey', 'appPaymentKey', 'appPublicKey', 'api'], 'safe'],
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
        $query = MyTabDistribution::find();

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
            'distributorId' => $this->distributorId,
            'parentDT' => $this->parentDT,
            'enabled' => $this->enabled,
            'isDebug' => $this->isDebug,
        ]);

        $query->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'centerLoginKey', $this->centerLoginKey])
            ->andFilterWhere(['like', 'centerPaymentKey', $this->centerPaymentKey])
            ->andFilterWhere(['like', 'appID', $this->appID])
            ->andFilterWhere(['like', 'appKey', $this->appKey])
            ->andFilterWhere(['like', 'appLoginKey', $this->appLoginKey])
            ->andFilterWhere(['like', 'appPaymentKey', $this->appPaymentKey])
            ->andFilterWhere(['like', 'appPublicKey', $this->appPublicKey])
            ->andFilterWhere(['like', 'api', $this->api]);

        return $dataProvider;
    }
}
