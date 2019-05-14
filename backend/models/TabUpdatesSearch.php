<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabUpdates;

/**
 * TabUpdatesSearch represents the model behind the search form of `backend\models\TabUpdates`.
 */
class TabUpdatesSearch extends TabUpdates
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameid', 'platformid'], 'integer'],
            [['type', 'url', 'version', 'filename', 'libversion', 'libfilename', 'packageversion', 'packagefilename', 'update_time', 'SVN_version'], 'safe'],
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
        $query = TabUpdates::find();

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
            'gameid' => $this->gameid,
            'platformid' => $this->platformid,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'libversion', $this->libversion])
            ->andFilterWhere(['like', 'libfilename', $this->libfilename])
            ->andFilterWhere(['like', 'packageversion', $this->packageversion])
            ->andFilterWhere(['like', 'packagefilename', $this->packagefilename])
            ->andFilterWhere(['like', 'SVN_version', $this->SVN_version]);

        return $dataProvider;
    }
}
