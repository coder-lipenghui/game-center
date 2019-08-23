<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ops\TabOpsMergeLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tab Ops Merge Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-ops-merge-log-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', 'Create Tab Ops Merge Log'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-body">
                                            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            
                            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                            'id',
            'distributionId',
            'gameId',
            'activeUrl',
            'passiveUrl',
            //'logTime',
            //'uid',

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                    </div>
    </div>
</div>
