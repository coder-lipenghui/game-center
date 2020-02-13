<?php

namespace backend\models\ops;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ops\TabUpdateScriptLog;

/**
 * TabUpdateScriptLogSearch represents the model behind the search form of `backend\models\ops\TabUpdateScriptLog`.
 */
class TabUpdateScriptLogSearch extends TabUpdateScriptLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'serverId', 'operator', 'status', 'logTime'], 'integer'],
            [['scriptName', 'info'], 'safe'],
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
        $query = TabUpdateScriptLog::find();

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
            'serverId' => $this->serverId,
            'operator' => $this->operator,
            'status' => $this->status,
            'logTime' => $this->logTime,
        ]);

        $query->andFilterWhere(['like', 'scriptName', $this->scriptName])
            ->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
