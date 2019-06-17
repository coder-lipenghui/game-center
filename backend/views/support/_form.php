<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabSuppor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-suppor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sponsor')->textInput() ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributorId')->textInput() ?>

    <?= $form->field($model, 'serverId')->textInput() ?>

    <?= $form->field($model, 'roleAccount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'number')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'verifier')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
