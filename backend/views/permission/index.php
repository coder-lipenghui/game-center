<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabPermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '权限管理');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-permission-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                <?= Html::a(Yii::t('app', '分配权限'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute'=>'uid',
                        'value'=>'u.username'
                    ],
                    ['attribute'=>'gameId','value'=>'game.name'],
                    ['attribute'=>'distributorId','value'=>'distributor.name'],
                    ['attribute'=>'distributionId','value'=>'distribution.platform'],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>




</div>
