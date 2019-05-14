<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabLogRole;

/**
 * TabLogRoleSearch represents the model behind the search form of `backend\models\TabLogRole`.
 */
class TabLogRoleSearch extends TabLogRole
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'zoneId', 'ctime', 'distId'], 'integer'],
            [['loginKey', 'token', 'roleId', 'roleName', 'roleLevel', 'zoneName', 'sku', 'createtime'], 'safe'],
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
        $query = TabLogRole::find();

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
            'zoneId' => $this->zoneId,
            'ctime' => $this->ctime,
            'distId' => $this->distId,
            'createtime' => $this->createtime,
        ]);

        $query->andFilterWhere(['like', 'loginKey', $this->loginKey])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'roleId', $this->roleId])
            ->andFilterWhere(['like', 'roleName', $this->roleName])
            ->andFilterWhere(['like', 'roleLevel', $this->roleLevel])
            ->andFilterWhere(['like', 'zoneName', $this->zoneName])
            ->andFilterWhere(['like', 'sku', $this->sku]);

        return $dataProvider;
    }
}
