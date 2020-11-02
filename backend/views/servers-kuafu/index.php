<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabServersKuafuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '跨服服务器');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-servers-kuafu-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '新增服务器'), ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', '设置跨服'), ['edit'], ['class' => 'btn btn-success']) ?>
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
                'id',
                ['attribute'=>'versionId','value'=>'gameVersion.name'],
                ['attribute'=>'gameId','value'=>'game.name'],
                'name',
                'index',
                //'status',
                'url:url',
                'netPort',
                //'masterPort',
                //'contentPort',
                //'smallDbPort',
                //'bigDbPort',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
        </div>
    </div>
</div>
