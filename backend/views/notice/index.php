<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabNoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '公告管理');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-notice-index">
    <div class="tab-orders-index">
        <div class="panel panel-default">
            <div class="panel-body">
                <p>
                    <?= Html::a(Yii::t('app', '新增公告'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
        </div>
    </div>
    <div class="tab-orders-index">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
                    $form=ActiveForm::begin([
                        "id"=>"myform",
                        "method"=>"get",
                        'fieldConfig' => ['template' => '{input}']
                    ]);
                ?>
                <div class="row">
                    <div class="col-md-1">
                        <?=$form->field($searchModel,'gameId')->dropDownList(
                            $games,
                            [
                                "class"=>"selectpicker form-control col-xs-2",
                                "data-width"=>"fit",
                                "id"=>"games",
                                "onchange"=>"changeGame(this)",
                                "title"=>"选择游戏"
                            ]
                        )?>
                    </div>
                    <div class="col-md-1">
                        <?=$form->field($searchModel,'distributionId')->dropDownList(
                            [],
                            [
                                "class"=>"selectpicker form-control col-xs-2",
                                "data-width"=>"fit",
                                "id"=>"games",
                                "onchange"=>"changeGame(this)",
                                "title"=>"分销商"
                            ]
                        )?>
                    </div>
                    <?php
                    ActiveForm::end()
                    ?>
                </div>
                <hr/>
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        'id',
                        [
                            'attribute'=>'gameId',
                            'value'=>'game.name'
                        ],
                        [
                            'attribute'=>'distributionId',
                            'label'=>'分销商',
                            'value'=>function($model){
                                $distribution=\backend\models\TabDistribution::findOne($model->distributionId);
                                $distributor=\backend\models\TabDistributor::findOne($distribution->distributorId);
                                return $distributor->name."(".$distribution->platform.")";
                            }
                        ],
                        'title',
                        [
                            'attribute'=>'body',
                            'value'=>function($model){
                                if (mb_strlen($model->body>30))
                                {
                                    return(mb_substr($model->body,0,30).'...');
                                }else{
                                    return $model->body;
                                }

                            }
                        ],
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]); ?>

                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>

</div>
