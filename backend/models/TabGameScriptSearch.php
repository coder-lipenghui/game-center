<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabGameScript;

/**
 * TabGameScriptSearch represents the model behind the search form of `backend\models\TabGameScript`.
 */
class TabGameScriptSearch extends TabGameScript
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'userId', 'logTime'], 'integer'],
            [['fileName', 'comment'], 'safe'],
            [['fileSize'], 'number'],
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
        $query = TabGameScript::find();

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
            'fileSize' => $this->fileSize,
            'userId' => $this->userId,
            'logTime' => $this->logTime,
        ]);

        $query->andFilterWhere(['like', 'fileName', $this->fileName])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
