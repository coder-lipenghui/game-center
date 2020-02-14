<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabCmdLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'GM命令记录');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cmd-log-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '执行命令'), ['create'], ['class' => 'btn btn-success']) ?>
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
//                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
                    ['attribute'=>'gameId','label'=>'游戏','value'=>'game.name'],
                    ['attribute'=>'distributorId','label'=>'分销商','value'=>'distributor.name'],
                    ['attribute'=>'serverId','label'=>'区服','value'=>'server.name'],
//                    'type',
                    ['attribute'=>'cmdName','label'=>'命令','value'=>'cmd.shortName'],
                    ['attribute'=>'cmdInfo','label'=>'参数'],
                    ['attribute'=>'operator','label'=>'执行人'],
                    ['attribute'=>'status','label'=>'状态'],
//                    'result',
                    ['attribute'=>'logTime','label'=>'时间','value'=>function($model){return date('yy-m-d H:i:s',$model->logTime);}],

//                    ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
