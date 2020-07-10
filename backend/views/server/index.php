<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabServersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '区服管理');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-servers-index">
    <div class="panel panel-default">
        <div class="panel-body">
                <p>
                    <?= Html::a(Yii::t('app', '新增区服'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>
        </div>
    </div>
    <div class="panel panel-default">

        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?php
//                echo $this->render('_search', ['model' => $searchModel]);
            ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => ['id',
                    [
                        'attribute'=>'gameId',
                        'value'=>'game.name'
                    ],
                    ['attribute'=>'distributorId','label'=>'分销商','value'=>'distributor.name'],
                    'name',
                    ['attribute'=>'index','label'=>'区Index'],
                    'status',
                    'url:url',
//                    'netPort',
//                    'masterPort',
//                    'contentPort',
//                    'smallDbPort',
//                    'bigDbPort',
                    ['attribute'=>'mergeId','label'=>'合区至','value'=>function($model){if (empty($model->mergeId)) return "未合区";}],
                    ['attribute'=>'openDateTime','label'=>'开区时间'],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>

    </div>




</div>
