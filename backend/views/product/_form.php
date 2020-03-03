<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'productId')->textInput() ?>

    <?= $form->field($model, 'productName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'productPrice')->textInput() ?>

    <?= $form->field($model, 'productScript')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'enable')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
