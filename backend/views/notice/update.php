<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabNotice */

$this->title = Yii::t('app', '修改: {name}', [
    'name' => $model->title,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '公告管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', '编辑');
?>
<div class="tab-notice-update">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'gameId')->textInput() ?>

            <?= $form->field($model, 'distributions')->textInput() ?>

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'starttime')->widget(DateTimePicker::classname(), [

                'removeButton' => false,
                'options' => [
                    'placeholder' => '',
                    'value'=>date('Y-m-d H:i:s',$model->starttime),
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true,
                ]
            ])->label(false); ?>

            <?= $form->field($model, 'endtime')->widget(DateTimePicker::classname(), [
                'removeButton' => false,
                'options' => [
                    'placeholder' => '',
                    'value'=>date('Y-m-d H:i:s',$model->endtime),
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true,
                ]
            ])->label(false); ?>

            <?= $form->field($model, 'rank')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
