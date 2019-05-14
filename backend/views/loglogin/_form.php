<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabLogLogin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-log-login-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameid')->textInput() ?>

    <?= $form->field($model, 'distributor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'playerId')->textInput() ?>

    <?= $form->field($model, 'ipAddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deviceOs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deviceVender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deviceId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deviceType')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <?= $form->field($model, 'loginKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
