<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabPlayers;

/**
 * TabPlayersSearch represents the model behind the search form of `backend\models\TabPlayers`.
 */
class TabPlayersSearch extends TabPlayers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'distributionId', 'gameId'], 'integer'],
            [['account', 'distributionUserId', 'distributionUserAccount', 'regdeviceId', 'regtime', 'regip'], 'safe'],
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
        $query = TabPlayers::find();

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
            'distributionId' => $this->distributionId,
            'gameId' => $this->gameId,
            'regtime' => $this->regtime,
        ]);

        $query->andFilterWhere(['like', 'account', $this->account])
            ->andFilterWhere(['like', 'distributionUserId', $this->distributionUserId])
            ->andFilterWhere(['like', 'distributionUserAccount', $this->distributionUserAccount])
            ->andFilterWhere(['like', 'regdeviceId', $this->regdeviceId])
            ->andFilterWhere(['like', 'regip', $this->regip]);

        return $dataProvider;
    }
}
