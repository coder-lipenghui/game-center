<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabOrdersLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tab Orders Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-orders-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tab Orders Log'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'gameid',
            'distributor',
            'orderid',
            'distributorOrderid',
            //'player_id',
            //'gameRoleid',
            //'gameRoleName',
            //'gameServerId',
            //'gameAccount',
            //'total',
            //'vcoinRatio',
            //'paymoney',
            //'payTime',
            //'orderTime',
            //'deviceId',
            //'isDebug',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
