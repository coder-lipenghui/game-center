<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabOrders;

/**
 * TabOrdersSearch represents the model behind the search form of `backend\models\TabOrders`.
 */
class TabOrdersSearch extends TabOrders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'distributionId', 'gameServerId'], 'integer'],
            [['orderId', 'distributorOrderId', 'playerId', 'gameRoleId', 'gameRoleName', 'gameAccount', 'goodName', 'payStatus', 'payMode', 'payTime', 'createTime', 'delivered'], 'safe'],
            [['payAmount'], 'number'],
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
        $query = TabOrders::find();

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
            'distributionId' => $this->distributionId,
            'gameServerId' => $this->gameServerId,
            'payAmount' => $this->payAmount,
            'payTime' => $this->payTime,
            'createTime' => $this->createTime,
        ]);

        $query->andFilterWhere(['like', 'orderId', $this->orderId])
            ->andFilterWhere(['like', 'distributorOrderId', $this->distributorOrderId])
            ->andFilterWhere(['like', 'playerId', $this->playerId])
            ->andFilterWhere(['like', 'gameRoleId', $this->gameRoleId])
            ->andFilterWhere(['like', 'gameRoleName', $this->gameRoleName])
            ->andFilterWhere(['like', 'gameAccount', $this->gameAccount])
            ->andFilterWhere(['like', 'goodName', $this->goodName])
            ->andFilterWhere(['like', 'payStatus', $this->payStatus])
            ->andFilterWhere(['like', 'payMode', $this->payMode])
            ->andFilterWhere(['like', 'delivered', $this->delivered]);

        return $dataProvider;
    }
}
