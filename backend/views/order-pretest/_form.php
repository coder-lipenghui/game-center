<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersPretest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-orders-pretest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'distributionId')->textInput() ?>

    <?= $form->field($model, 'distributionUserId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'rate')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'got')->textInput() ?>

    <?= $form->field($model, 'rcvRoleId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rcvRoleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rcvServerId')->textInput() ?>

    <?= $form->field($model, 'rcvTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
