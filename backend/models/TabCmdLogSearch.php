<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabCmdLog;

/**
 * TabCmdLogSearch represents the model behind the search form of `backend\models\TabCmdLog`.
 */
class TabCmdLogSearch extends TabCmdLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'distributorId', 'serverId', 'type', 'operator', 'status', 'logTime'], 'integer'],
            [['cmdName', 'cmdInfo', 'result'], 'safe'],
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
        $query = TabCmdLog::find();

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
            'serverId' => $this->serverId,
            'type' => $this->type,
            'operator' => $this->operator,
            'status' => $this->status,
            'logTime' => $this->logTime,
        ]);

        $query->andFilterWhere(['like', 'cmdName', $this->cmdName])
            ->andFilterWhere(['like', 'cmdInfo', $this->cmdInfo])
            ->andFilterWhere(['like', 'result', $this->result]);

        return $dataProvider;
    }
}
