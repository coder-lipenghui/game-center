<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabServers;

/**
 * TabServersSearch represents the model behind the search form of `backend\models\TabServers`.
 */
class TabServersSearch extends TabServers
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId',  'index', 'status', 'netPort', 'masterPort', 'contentPort', 'smallDbPort', 'bigDbPort', 'mergeId'], 'integer'],
            [['distributions'],'string'],
            [['name', 'url', 'openDateTime', 'createTime'], 'safe'],
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
        $query = TabServers::find();

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
            'distributions' => $this->distributions,
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
