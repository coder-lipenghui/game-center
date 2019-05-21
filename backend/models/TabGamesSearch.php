<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * TabGamesSearch represents the model behind the search form of `backend\models\TabGames`.
 */
class TabGamesSearch extends TabGames
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'logo', 'info', 'sku','loginKey','paymentKey', 'createTime', 'copyright_number', 'copyright_isbn', 'copyright_press', 'copyright_author'], 'safe'],
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
        $query = TabGames::find();

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
            'createTime' => $this->createTime,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'info', $this->info])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'loginKey', $this->loginKey])
            ->andFilterWhere(['like', 'paymentKey', $this->paymentKey])
            ->andFilterWhere(['like', 'copyright_number', $this->copyright_number])
            ->andFilterWhere(['like', 'copyright_isbn', $this->copyright_isbn])
            ->andFilterWhere(['like', 'copyright_press', $this->copyright_press])
            ->andFilterWhere(['like', 'copyright_author', $this->copyright_author]);

        return $dataProvider;
    }
    public static function getAllowable($params)
    {
        $data=TabPermission::find()->select('gameId')->where(['uid'=>\Yii::$app->user->id])->asArray()->all();
        if ($data!=null && count($data)>0)
        {
            $array=ArrayHelper::map($data,'gameId','gameId');
            $idArr=[];
            foreach ($array as $key=>$value)
            {
                array_push($idArr,(int)$value);
            }
            return TabGames::find()->select(['id','name'])->asArray()->where(['id'=>$idArr])->all();
        }else{
            return [];
        }

    }
}
