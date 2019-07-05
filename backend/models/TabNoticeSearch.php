<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabNotice;
use yii\db\Expression;
use backend\models\MyTabPermission;
/**
 * TabNoticeSearch represents the model behind the search form of `backend\models\TabNotice`.
 */
class TabNoticeSearch extends TabNotice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gameId', 'distributions', 'starttime', 'endtime', 'rank'], 'integer'],
            [['title', 'body'], 'safe'],
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
        $query = TabNotice::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
//             uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
//            return $dataProvider;
        }
        if ($this->distributions)
        {
            $query->andWhere(new Expression('FIND_IN_SET(:distributions, distributions)',['distributions'=>$this->distributions]));
        }
        $permission=new MyTabPermission();
        $games=$permission->allowAccessGame();
        if (empty($games[$this->gameId]))
        {
            $query->where('0=1');
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'gameId' => $this->gameId,
            'starttime' => $this->starttime,
            'endtime' => $this->endtime,
            'rank' => $this->rank,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
