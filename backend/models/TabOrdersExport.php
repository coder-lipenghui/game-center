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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distributorId','payTime'],'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
        $query->andFilterWhere(['distributorId'=>$this->distributorId])
            ->andFilterWhere(['payStatus'=>'1'])
//            ->andFilterWhere(['like', 'payTime', $this->payTime])
            ->andFilterWhere(["FROM_UNIXTIME(payTime,'%Y-%m')"=>$this->payTime])
            ->select(['gameId','orderId','distributionOrderId','payAmount','payTime'=>'FROM_UNIXTIME(payTime,\'%Y-%m-%d %H:%i:%s\')'])->asArray()
            ->orderBy('gameId');
//        exit($query->createCommand()->getRawSql());
        return $query->all();
    }
}
