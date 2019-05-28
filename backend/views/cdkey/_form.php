<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkey */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cdkey-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributorId')->textInput() ?>

    <?= $form->field($model, 'distributionId')->textInput() ?>

    <?= $form->field($model, 'varietyId')->textInput() ?>

    <?= $form->field($model, 'cdkey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'used')->textInput() ?>

    <?= $form->field($model, 'createTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
