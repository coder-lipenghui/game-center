<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabPlayers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-players-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'distributor')->textInput() ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributorPlayerId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uniqueKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'regdeviceId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'regtime')->textInput() ?>

    <?= $form->field($model, 'regip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'totalrecharge')->textInput() ?>

    <?= $form->field($model, 'rechargetimes')->textInput() ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
