<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabLogLoginSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tab Log Logins');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-log-login-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tab Log Login'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'playerId',
            'ipAddress',
            //'deviceOs',
            //'deviceVender',
            //'deviceId',
            //'deviceType',
            //'timestamp',
            //'loginKey',
            //'token',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
