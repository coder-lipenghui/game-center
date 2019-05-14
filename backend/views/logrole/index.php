<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabLogRoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tab Log Roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-log-role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tab Log Role'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'loginKey',
            'token',
            'roleId',
            'roleName',
            //'roleLevel',
            //'zoneId',
            //'zoneName',
            //'ctime:datetime',
            //'distId',
            //'sku',
            //'createtime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
