<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '订单管理');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?= Html::a("订单导出", ['export', 'id' => $searchModel->id], ['class' => 'btn btn-success']) ?>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <?php Pjax::begin(); ?>
        <?php  echo $this->render('_search', ['model' => $searchModel,'games'=>$games]); ?>
        <hr/>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
                ['attribute'=>'gameId','label'=>'游戏','value'=>'game.name'],
                ['attribute'=>'gameServerId','label'=>'区','value'=>'server.index'],
                ['attribute'=>'orderId','label'=>'订单号'],

                ['attribute'=>'gameAccount','label'=>'账号'],
                ['attribute'=>'gameRoleName','label'=>'角色名'],
                ['attribute'=>'payAmount','label'=>'金额(元)','value'=>function($model){return $model->payAmount/100;}],
                ['attribute'=>'payStatus','label'=>'状态','value'=>function($model){return $model->payStatus==1?"已支付":"未支付";}],
//                ['attribute'=>'payMode','label'=>'方式'],
                'payTime:datetime',
                ['attribute'=>'delivered','label'=>'发货','value'=>function($model){return $model->delivered==1?"已发":"未发";}],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template'=>'{view}'
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
