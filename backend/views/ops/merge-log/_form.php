<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ops\TabOpsMergeLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-ops-merge-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'distributionId')->textInput() ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'activeUrl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passiveUrl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logTime')->textInput() ?>

    <?= $form->field($model, 'uid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
