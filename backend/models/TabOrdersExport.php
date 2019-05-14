<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabOrders;

/**
 * TabOrdersExport represents the model behind the search form of `backend\models\TabOrders`.
 */
class TabOrdersExport extends TabOrders
{
    public $dists=[];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            ['gameid', 'distributor', 'gameServerId', 'isDebug'], 'integer'],
//            [['orderid', 'distributorOrderid', 'player_id', 'gameRoleid', 'gameRoleName', 'gameAccount', 'goodName', 'ispay', 'payTime', 'orderTime', 'deviceId', 'delivered'], 'safe'],
//            [['total', 'vcoinRatio', 'paymoney'], 'number'],
            [['dists','gameid','payTime'],'required'],

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

    /**
     * 根据渠道id、时间导出订单数据
     * @param $params 包含渠道id、时间
     */
    public function export($params)
    {
        $query = TabOrders::find();

        $this->load($params);

        if (!$this->validate())
        {
            $dataProvider=new ActiveDataProvider([
                'query'=>$query
            ]);
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['distributor'=>$this->dists])
            ->andFilterWhere(['ispay'=>'1'])
            ->andFilterWhere(['like', 'payTime', $this->payTime])
            ->select(['distributor','orderid','distributorOrderid','paymoney','payTime'])->asArray()
            ->orderBy('distributor');
//        exit($query->createCommand()->getRawSql());
        return $query->all();
    }
}
