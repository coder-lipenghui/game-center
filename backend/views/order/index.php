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
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

//                'id',
//                'gameId',
//                'distributionId',
                'orderId',
//                'distributionOrderId',
//                'distributionUserId',
                //'gameRoleId',
                'gameServerId',
                'gameAccount',
                'gameRoleName',
                //'gameServername',
                //'productName',
                'payAmount',
                'payStatus',
                'payMode',
                'payTime:datetime',
                //'createTime:datetime',
                'delivered',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template'=>'{view}'
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
