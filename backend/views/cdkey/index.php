<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabCdkeySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '激活码');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cdkey-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '生成激活码'), ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', '激活码导出'), ['view'], ['class' => 'btn btn-success']) ?>
            <hr/>
        </div>
        <div class="panel-body">

            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'varietyId',
                    'gameId',
                    'distributorId',
                    'distributionId',
                    'cdkey',
                    //'used',
                    //'createTime:datetime',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
