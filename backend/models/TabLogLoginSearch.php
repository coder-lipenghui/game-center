<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabLogLogin;

/**
 * TabLogLoginSearch represents the model behind the search form of `backend\models\TabLogLogin`.
 */
class TabLogLoginSearch extends TabLogLogin
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameid', 'playerId'], 'integer'],
            [['distributor', 'ipAddress', 'deviceOs', 'deviceVender', 'deviceId', 'deviceType', 'timestamp', 'loginKey', 'token'], 'safe'],
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
        $query = TabLogLogin::find();

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
            'gameid' => $this->gameid,
            'playerId' => $this->playerId,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'distributor', $this->distributor])
            ->andFilterWhere(['like', 'ipAddress', $this->ipAddress])
            ->andFilterWhere(['like', 'deviceOs', $this->deviceOs])
            ->andFilterWhere(['like', 'deviceVender', $this->deviceVender])
            ->andFilterWhere(['like', 'deviceId', $this->deviceId])
            ->andFilterWhere(['like', 'deviceType', $this->deviceType])
            ->andFilterWhere(['like', 'loginKey', $this->loginKey])
            ->andFilterWhere(['like', 'token', $this->token]);

        return $dataProvider;
    }
}
