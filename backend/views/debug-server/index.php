<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabDebugServersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '测试服列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-debug-servers-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '新增'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-body">
                <?php Pjax::begin(); ?>
                                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            
                            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
        'columns' => [
//                ['class' => 'yii\grid\SerialColumn'],

//                            'id',
            ['attribute'=>'versionId','value'=>'gameVersion.name'],
//            'gameId',
            'name',
            'index',
            //'status',
            'url:url',
            'netPort',
            'masterPort',
            'contentPort',
            'smallDbPort',
            'bigDbPort',
            //'mergeId',
            'openDateTime:datetime',
            //'createTime',

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
