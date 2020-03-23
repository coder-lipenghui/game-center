<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabContact */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-contact-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'activeAccount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'activeRoleId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passivityAccount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passivityRoleId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'serverId')->textInput() ?>

    <?= $form->field($model, 'logTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
