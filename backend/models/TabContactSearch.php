<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabContact;

/**
 * TabContactSearch represents the model behind the search form of `backend\models\TabContact`.
 */
class TabContactSearch extends TabContact
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'serverId', 'logTime'], 'integer'],
            [['activeAccount', 'activeRoleId', 'passivityAccount', 'passivityRoleId'], 'safe'],
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
        $query = TabContact::find();

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
            'serverId' => $this->serverId,
            'logTime' => $this->logTime,
        ]);

        $query->andFilterWhere(['like', 'activeAccount', $this->activeAccount])
            ->andFilterWhere(['like', 'activeRoleId', $this->activeRoleId])
            ->andFilterWhere(['like', 'passivityAccount', $this->passivityAccount])
            ->andFilterWhere(['like', 'passivityRoleId', $this->passivityRoleId]);

        return $dataProvider;
    }
}
