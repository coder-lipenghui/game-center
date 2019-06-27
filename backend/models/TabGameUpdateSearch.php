<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabGameUpdate;

/**
 * TabGameUpdateSearch represents the model behind the search form of `backend\models\TabGameUpdate`.
 */
class TabGameUpdateSearch extends TabGameUpdate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'distributionId', 'executeTime', 'enable'], 'integer'],
            [['versionFile', 'projectFile', 'version', 'svn', 'comment'], 'safe'],
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
        $query = TabGameUpdate::find();

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
            'executeTime' => $this->executeTime,
            'enable' => $this->enable,
        ]);

        $query->andFilterWhere(['like', 'versionFile', $this->versionFile])
            ->andFilterWhere(['like', 'projectFile', $this->projectFile])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'svn', $this->svn])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
