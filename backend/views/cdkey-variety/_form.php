<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkeyVariety */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cdkey-variety-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'items')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'once')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
