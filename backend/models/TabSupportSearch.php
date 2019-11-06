<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabSupport;
use yii\helpers\Html;
/**
 * TabSupportSearch represents the model behind the search form of `backend\models\TabSupport`.
 */
class TabSupportSearch extends TabSupport
{
    public $template="";
//    public $buttons=[];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sponsor', 'gameId', 'distributorId', 'serverId', 'type', 'number', 'status', 'verifier'], 'integer'],
            [['roleAccount', 'reason'], 'safe'],
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
        $query = TabSupport::find();

        $permission=TabPermission::find()->select(['gameId','distributorId'])->where(['uid'=>Yii::$app->user->id,'support'=>1])->all();
        $games=[];
        $distributors=[];
        for ($i=0;$i<count($permission);$i++)
        {
            $games[]=$permission[$i]['gameId'];
            $distributors[]=$permission[$i]['distributorId'];
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
//            'sponsor' => \Yii::$app->user->id,
            'serverId' => $this->serverId,
            'type' => $this->type,
            'number' => $this->number,
            'status' => $this->status,
            'verifier' => $this->verifier,
        ]);
        $query->andWhere(['or',['gameId'=>$games,'distributorId'=>$distributors],['sponsor'=>Yii::$app->user->id]]);

        $query->andFilterWhere(['like', 'roleAccount', $this->roleAccount])
            ->orderBy('status')
            ->andFilterWhere(['like', 'reason', $this->reason]);
//        exit($query->createCommand()->getRawSql());

        return $dataProvider;
    }
    public function buttons()
    {
//        exit(json_encode(['uid'=>\Yii::$app->user->id,'gameId'=>$this->gameId,'distributorId'=>$this->distributorId,'support'=>1]));
        $permission=TabPermission::find()->where(['uid'=>\Yii::$app->user->id,'gameId'=>$this->gameId,'distributorId'=>$this->distributorId,'support'=>1])->one();
        if ($permission)
        {
            $this->template="{:allow}{:refuse}{:delete}";
            return [
                'refuse' => function ($url, $model, $key) {
                    $options = [];
                    return Html::a('<button type="button" class="btn btn-warning btn-sm">拒绝</button>','javascript:;', $options);
                },
                'allow' => function ($url, $model, $key) {
                    $options = [];
                    return Html::a('<button type="button" class="btn btn-success btn-sm">同意</button>','javascript:;', $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ];
                    return Html::a('<button type="button" class="btn btn-danger btn-sm">删除</button>',$url, $options);
                },
            ];
        }else{
            $this->template="{:delete}";
            return [
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ];
                    return Html::a('<button type="button" class="btn btn-danger btn-sm">删除</button>',$url, $options);
                },
            ];
        }
    }
    public function template()
    {
        return $this->template;
    }
}
