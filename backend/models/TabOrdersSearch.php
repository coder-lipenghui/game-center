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
    public $type=1;
    public $payStatus='1';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId','distributorId', 'distributionId', 'gameServerId', 'payTime', 'createTime','type'], 'integer'],
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

        $query = TabOrders::find();

        // add conditions that should always apply here
        $this->load($params);
//        exit(json_encode($params));
        if ($this->type==2)
        {
            $query=TabOrdersDebug::find();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gameId' => $this->gameId,
            'distributorId'=>$this->distributorId,
            'distributionId' => $this->distributionId,
            'gameServerId' => $this->gameServerId,
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

//        $query->orderBy('payStatus DESC');
        return $dataProvider;
    }
}
