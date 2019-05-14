<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\TabChatControl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-chat-control-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userPwd')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'userPTFlag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isManager')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
