<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '计费表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-product-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', 'Create Tab Product'), ['create'], ['class' => 'btn btn-success']) ?>
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
//                    ['class' => 'yii\grid\SerialColumn'],
//                    'id',
                    'productId',
                    ['attribute'=>'gameId','value'=>'game.name'],
                    ['attribute'=>'type','label'=>'类型','value'=>function($model){ return $model->type==1?"常规充值":"脚本触发";}],

                    'productName',
                    ['label'=>'单价','attribute'=>'productPrice','value'=>function($model){return ($model->productPrice/100)."元";}],
                    'productScript',
                    ['attribute'=>'enable','value'=>function($model){return $model->enable==1?"已启用":"未启用";}],
                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
