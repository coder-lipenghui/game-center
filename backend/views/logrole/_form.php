<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabLogRole */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-log-role-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'loginKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'roleId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'roleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'roleLevel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zoneId')->textInput() ?>

    <?= $form->field($model, 'zoneName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ctime')->textInput() ?>

    <?= $form->field($model, 'distId')->textInput() ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'createtime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
