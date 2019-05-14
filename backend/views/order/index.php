<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '订单详情');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-orders-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//            'id',
                    'gameId',
                    'distributionId',
                    'orderId',
                    'distributorOrderId',
                    'playerId',
                    'gameRoleId',
                    'gameRoleName',
                    'gameServerId',
                    'gameAccount',
                    'goodName',
                    'payAmount',
                    'payStatus',
                    'payMode',
                    'payTime',
                    'createTime',
                    'delivered',

//            ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
