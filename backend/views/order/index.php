<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabOrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tab Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tab Orders'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'gameId',
            'distributionId',
            'orderId',
            'distributionOrderId',
            //'distributionUserId',
            //'gameRoleId',
            //'gameRoleName',
            //'gameServerId',
            //'gameServername',
            //'gameAccount',
            //'productName',
            //'payAmount',
            //'payStatus',
            //'payMode',
            //'payTime:datetime',
            //'createTime:datetime',
            //'delivered',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
