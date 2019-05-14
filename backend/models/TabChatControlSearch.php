<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabChatControl;

/**
 * TabChatControlSearch represents the model behind the search form of `backend\models\TabChatControl`.
 */
class TabChatControlSearch extends TabChatControl
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'isManager'], 'integer'],
            [['userName', 'userPwd', 'userPTFlag'], 'safe'],
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
        $query = TabChatControl::find();

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
            'isManager' => $this->isManager,
        ]);

        $query->andFilterWhere(['like', 'userName', $this->userName])
            ->andFilterWhere(['like', 'userPwd', $this->userPwd])
            ->andFilterWhere(['like', 'userPTFlag', $this->userPTFlag]);

        return $dataProvider;
    }
}
