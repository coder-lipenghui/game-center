<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabDebugServers;

/**
 * TabDebugServersSearch represents the model behind the search form of `backend\models\TabDebugServers`.
 */
class TabDebugServersSearch extends TabDebugServers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'versionId', 'gameId', 'index', 'status', 'netPort', 'masterPort', 'contentPort', 'smallDbPort', 'bigDbPort', 'mergeId','kPort'], 'integer'],
            [['name', 'url', 'openDateTime', 'createTime','kUrl'], 'safe'],
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
        $query = TabDebugServers::find();

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
            'versionId' => $this->versionId,
            'gameId' => $this->gameId,
            'index' => $this->index,
            'status' => $this->status,
            'netPort' => $this->netPort,
            'masterPort' => $this->masterPort,
            'contentPort' => $this->contentPort,
            'smallDbPort' => $this->smallDbPort,
            'bigDbPort' => $this->bigDbPort,
            'mergeId' => $this->mergeId,
            'openDateTime' => $this->openDateTime,
            'createTime' => $this->createTime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
