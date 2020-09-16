<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabOrdersPretest;

/**
 * TabOrdersPretestSearch represents the model behind the search form of `backend\models\TabOrdersPretest`.
 */
class TabOrdersPretestSearch extends TabOrdersPretest
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'distributionId', 'total', 'rate', 'type', 'got', 'rcvServerId', 'rcvTime'], 'integer'],
            [['distributionUserId', 'rcvRoleId', 'rcvRoleName'], 'safe'],
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
        $query = TabOrdersPretest::find();

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
            'total' => $this->total,
            'rate' => $this->rate,
            'type' => $this->type,
            'got' => $this->got,
            'rcvServerId' => $this->rcvServerId,
            'rcvTime' => $this->rcvTime,
        ]);

        $query->andFilterWhere(['like', 'distributionUserId', $this->distributionUserId])
            ->andFilterWhere(['like', 'rcvRoleId', $this->rcvRoleId])
            ->andFilterWhere(['like', 'rcvRoleName', $this->rcvRoleName]);

        return $dataProvider;
    }
}
