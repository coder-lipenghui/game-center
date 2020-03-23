<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabOrdersRebate;

/**
 * TabOrdersRebateSearch represents the model behind the search form of `backend\models\TabOrdersRebate`.
 */
class TabOrdersRebateSearch extends TabOrdersRebate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'distributorId', 'distributionId', 'gameServerId', 'productId', 'payTime', 'createTime'], 'integer'],
            [['orderId', 'distributionOrderId', 'distributionUserId', 'gameRoleId', 'gameRoleName', 'gameServername', 'gameAccount', 'productName', 'payStatus', 'payMode', 'delivered'], 'safe'],
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
        $query = TabOrdersRebate::find();

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
            'distributionId' => $this->distributionId,
            'gameServerId' => $this->gameServerId,
            'productId' => $this->productId,
            'payAmount' => $this->payAmount,
            'payTime' => $this->payTime,
            'createTime' => $this->createTime,
        ]);

        $query->andFilterWhere(['like', 'orderId', $this->orderId])
            ->andFilterWhere(['like', 'distributionOrderId', $this->distributionOrderId])
            ->andFilterWhere(['like', 'distributionUserId', $this->distributionUserId])
            ->andFilterWhere(['like', 'gameRoleId', $this->gameRoleId])
            ->andFilterWhere(['like', 'gameRoleName', $this->gameRoleName])
            ->andFilterWhere(['like', 'gameServername', $this->gameServername])
            ->andFilterWhere(['like', 'gameAccount', $this->gameAccount])
            ->andFilterWhere(['like', 'productName', $this->productName])
            ->andFilterWhere(['like', 'payStatus', $this->payStatus])
            ->andFilterWhere(['like', 'payMode', $this->payMode])
            ->andFilterWhere(['like', 'delivered', $this->delivered]);

        return $dataProvider;
    }
}
