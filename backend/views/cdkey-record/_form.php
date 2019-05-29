<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkeyRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cdkey-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributionId')->textInput() ?>

    <?= $form->field($model, 'account')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serverId')->textInput() ?>

    <?= $form->field($model, 'roleId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'roleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cdkey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
