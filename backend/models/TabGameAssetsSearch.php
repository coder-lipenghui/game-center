<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabGameAssets;

/**
 * TabGameAssetsSearch represents the model behind the search form of `backend\models\TabGameAssets`.
 */
class TabGameAssetsSearch extends TabGameAssets
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'distributionId', 'total', 'executeTime', 'enable'], 'integer'],
            [['versionFile', 'projectFile', 'versionCode', 'versionName', 'comment'], 'safe'],
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
        $query = TabGameAssets::find();

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
            'total' => $this->total,
            'executeTime' => $this->executeTime,
            'enable' => $this->enable,
        ]);

        $query->andFilterWhere(['like', 'versionFile', $this->versionFile])
            ->andFilterWhere(['like', 'projectFile', $this->projectFile])
            ->andFilterWhere(['like', 'versionCode', $this->versionCode])
            ->andFilterWhere(['like', 'versionName', $this->versionName])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
