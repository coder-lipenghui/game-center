<?php

namespace backend\models;

use backend\models\MyTabDistribution;
use backend\models\MyTabFeedback;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabFeedback;

/**
 * TabFeedbackSearch represents the model behind the search form of `backend\models\TabFeedback`.
 */
class TabFeedbackSearch extends TabFeedback
{
    /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['gameId', 'distributorId'], 'required'],
            [['gameId', 'distributorId', 'distributionId', 'serverId', 'state'], 'integer'],
            [['account', 'roleName', 'title', 'content'], 'string', 'max' => 255],
            [['roleId'], 'string', 'max' => 200],
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
        $query = TabFeedback::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        MyTabFeedback::TabSuffix($this->gameId,$this->distributorId);
        $query = MyTabFeedback::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'gameId' => $this->gameId,
            'distributorId' => $this->distributorId,
            'distributionId' => $this->distributionId,
            'serverId' => $this->serverId,
            'state' => $this->state,
        ]);

        $query->andFilterWhere(['like', 'account', $this->account])
            ->andFilterWhere(['like', 'roleId', $this->roleId])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);
//        exit($query->createCommand()->getRawSql());
        return $dataProvider;
    }
}
