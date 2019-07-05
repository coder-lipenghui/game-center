<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabNoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '公告管理');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("@web/js/common.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/notice.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJs('
    handleChangeGame();
');
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
                    ]);
                ?>
                <div class="row">
                    <div class="col-md-1">
                        <?=$form->field($searchModel,'gameId')->dropDownList(
                            $games,
                            [
                                "class"=>"selectpicker form-control col-xs-2",
                                "data-width"=>"fit",
                                "id"=>"noticeGames",
                                "onchange"=>"handleChangeGame()",
                                "title"=>"选择游戏"
                            ]
                        )->label(false)?>
                    </div>
                    <div class="col-md-1">
                        <?= Html::dropDownList("分销商",
                            $distributors,
                            [],
                            [
                                'class'=>'selectpicker form-control col-xs-2',
                                'title'=>'分销商',
                                'id'=>'noticeDistributors',
                                'onchange'=>'handleIndexChangeDistributor()'
                            ])?>
                    </div>
                    <div class="col-md-2">
                        <?=$form->field($searchModel,'distributions')->dropDownList(
                            [],
                            [
                                "class"=>"selectpicker form-control col-xs-2",
                                "data-width"=>"fit",
                                "id"=>"noticeDistributions",
                                "title"=>"平台"
                            ]
                        )->label(false)?>
                    </div>
                    <div class="col-md-1">
                        <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <div class="row">

                    <?php
                    ActiveForm::end()
                    ?>
                </div>
                <?php Pjax::begin(); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute'=>'gameId',
                            'value'=>'game.name'
                        ],
                        'distributions',
                        'title',
                        [
                            'attribute'=>'body',
                            'value'=>function($model){
                                if (mb_strlen($model->body)>30)
                                {
                                    return(mb_substr($model->body,0,8).'...');
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
