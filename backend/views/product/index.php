<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '计费表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-product-index">
    <div class="panel panel-default">
        <div class="panel panel-body">
                <?php Pjax::begin(); ?>
            <div class="tab-product-search row">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]); ?>
                <div class="col-md-2"><?= $form->field($searchModel, 'gameId')->dropDownList($games)->label(false) ?></div>
                <div class="col-md-2"><?= $form->field($searchModel, 'type')->dropDownList([0=>'类型',1=>'常规',2=>'脚本'])->label(false) ?></div>
                <div class="col-md-2"><?= $form->field($searchModel, 'productId')->input(['placeholder'=>'计费点ID'])->label(false) ?></div>
                <div class="col-md-2"><?= $form->field($searchModel, 'productName')->label(false)?></div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', '查看'), ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <div class="col-md-2">
                    <?= Html::a(Yii::t('app', '新增计费点'), ['create'], ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
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
