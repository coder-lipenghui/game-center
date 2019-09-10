<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameScript */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-game-script-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'fileName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fileSize')->textInput() ?>

    <?= $form->field($model, 'userId')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
