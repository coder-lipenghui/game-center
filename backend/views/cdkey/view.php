<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\TabGames;
use backend\models\TabDistributor;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkey */

$this->title = "激活码导出";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '激活码管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tab-cdkey-view">
    <div class="panel panel-default">
        <?php $form = ActiveForm::begin([
            'fieldConfig' => ['template' => '{input}'],
        ]); ?>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-1">
                    <?= $form->field($model, 'gameId')->dropDownList(
                        ArrayHelper::map(TabGames::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListGame",
                            "title"=>"选择游戏"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'distributorId')->dropDownList(
                        ArrayHelper::map(TabDistributor::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListDistributor",
                            "title"=>"分销商"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'varietyId')->dropDownList(
                        ArrayHelper::map(\backend\models\TabCdkeyVariety::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListCDKEYVariety",
                            "title"=>"激活码分类"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <hr/>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="panel-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'varietyId',
                        'label'=>'礼包类型',
                        'value'=>function($data){
                            return \backend\models\TabCdkeyVariety::findOne($data['varietyId'])->name;
                        }
                    ],
                    [
                        'attribute'=>'total',
                        'label'=>'激活码数量',
                        'value'=>function($data)
                        {
                            return ($data['total']/10000)."万";
                        }
                    ],
//                    'gameId',
//                    'distributorId',
                    [
                        'class' => 'common\components\ActionColumn',
                        'template' => '{:export}',
                        'urlCreator'=>function ($action, $model,$key,$index,$column) {
                            $params = $model;
                            $params[0] = $column->controller ? $column->controller . '/' . $action : $action;
                            return Url::toRoute($params);
                        },
                        'buttons' => [
                            'export' => function ($url, $model, $key) {
                                $options = [
                                    'title' => Yii::t('yii', '导出激活码'),
                                    'aria-label' => Yii::t('yii', '导出激活码'),
                                    'data-pjax' => '0',
                                ];
                                return Html::a('<span class="glyphicon glyphicon-export"></span>', $url, $options);
                            },
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
