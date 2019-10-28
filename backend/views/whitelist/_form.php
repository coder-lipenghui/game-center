<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabWhitelist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-whitelist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributionId')->textInput() ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'distributionUserId')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
