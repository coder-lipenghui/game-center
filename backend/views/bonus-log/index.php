<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabBonusLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tab Bonus Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-bonus-log-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', 'Create Tab Bonus Log'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-body">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            
                <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

    //              'id',
                    ['attribute'=>'gameId','label'=>'游戏名称','value'=>'game.name'],
                    ['attribute'=>'distributorId','label'=>'分销商','value'=>'distributor.name'],
                    ['attribute'=>'orderId','label'=>'订单号'],
                    ['attribute'=>'addBindAmount','label'=>'不含充值积分额度'],
                    ['attribute'=>'addUnbindAmount','label'=>'含充值积分额度'],
                    ['attribute'=>'logTime','label'=>'记录时间'],

                    ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
