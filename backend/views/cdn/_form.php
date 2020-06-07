<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cdn-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'updateUrl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'assetsUrl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'platform')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'secretId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'secretKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
