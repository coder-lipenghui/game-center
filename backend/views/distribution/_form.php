<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabDistribution */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-distribution-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'platform')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'distributorId')->textInput() ?>

    <?= $form->field($model, 'parentDT')->textInput() ?>

    <?= $form->field($model, 'centerLoginKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'centerPaymentKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appLoginKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appPaymentKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'appPublicKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enabled')->textInput() ?>

    <?= $form->field($model, 'isDebug')->textInput() ?>

    <?= $form->field($model, 'api')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'packageName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'versionCode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'versionName')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
