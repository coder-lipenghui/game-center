<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabCdkeyRecord;

/**
 * TabCdkeyRecordSearch represents the model behind the search form of `backend\models\TabCdkeyRecord`.
 */
class TabCdkeyRecordSearch extends TabCdkeyRecord
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'distributionId', 'serverId', 'logTime'], 'integer'],
            [['account', 'roleId', 'roleName', 'cdkey'], 'safe'],
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
        $query = TabCdkeyRecord::find();

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
            'serverId' => $this->serverId,
            'logTime' => $this->logTime,
        ]);

        $query->andFilterWhere(['like', 'account', $this->account])
            ->andFilterWhere(['like', 'roleId', $this->roleId])
            ->andFilterWhere(['like', 'roleName', $this->roleName])
            ->andFilterWhere(['like', 'cdkey', $this->cdkey]);

        return $dataProvider;
    }
}
