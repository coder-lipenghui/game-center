<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '账号管理');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '新增账号'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'username',
//                    'auth_key',
//                    'password_hash',
//                    'password_reset_token',
                    //'email:email',
                    'status',
                    'created_at',
                    //'updated_at',
                    //'verification_token',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
