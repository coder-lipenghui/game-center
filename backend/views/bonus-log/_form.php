<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabBonusLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-bonus-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributorId')->textInput() ?>

    <?= $form->field($model, 'orderId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'addBindAmount')->textInput() ?>

    <?= $form->field($model, 'addUnbindAmount')->textInput() ?>

    <?= $form->field($model, 'logTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
