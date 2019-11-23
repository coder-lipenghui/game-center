<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabBonusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tab Bonuses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-bonus-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', 'Create Tab Bonus'), ['create'], ['class' => 'btn btn-success']) ?>
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

//                            'id',
                ['attribute'=>'gameId','value'=>'game.name'],
                ['attribute'=>'distributorId','value'=>'distributor.name'],
                'bindAmount',
                'unbindAmount',
                'bindRatio',
                'unbindRatio',

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
