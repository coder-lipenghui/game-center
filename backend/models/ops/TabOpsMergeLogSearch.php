<?php

namespace backend\models\ops;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ops\TabOpsMergeLog;

/**
 * TabOpsMergeLogSearch represents the model behind the search form of `backend\models\ops\TabOpsMergeLog`.
 */
class TabOpsMergeLogSearch extends TabOpsMergeLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'distributionId', 'gameId', 'uid'], 'integer'],
            [['activeUrl', 'passiveUrl', 'logTime'], 'safe'],
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
        $query = TabOpsMergeLog::find();

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
            'gameId' => $this->gameId,
            'logTime' => $this->logTime,
            'uid' => $this->uid,
        ]);

        $query->andFilterWhere(['like', 'activeUrl', $this->activeUrl])
            ->andFilterWhere(['like', 'passiveUrl', $this->passiveUrl]);

        return $dataProvider;
    }
}
