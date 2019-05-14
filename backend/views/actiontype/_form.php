<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabActionType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-action-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'actionId')->textInput() ?>

    <?= $form->field($model, 'actionType')->textInput() ?>

    <?= $form->field($model, 'actionName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'actionDesp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'actionLua')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
