<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabActionType;

/**
 * TabActionTypeSearch represents the model behind the search form of `backend\models\TabActionType`.
 */
class TabActionTypeSearch extends TabActionType
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'actionId', 'actionType'], 'integer'],
            [['actionName', 'actionDesp', 'actionLua'], 'safe'],
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
        $query = TabActionType::find();

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
            'actionId' => $this->actionId,
            'actionType' => $this->actionType,
        ]);

        $query->andFilterWhere(['like', 'actionName', $this->actionName])
            ->andFilterWhere(['like', 'actionDesp', $this->actionDesp])
            ->andFilterWhere(['like', 'actionLua', $this->actionLua]);

        return $dataProvider;
    }
}
