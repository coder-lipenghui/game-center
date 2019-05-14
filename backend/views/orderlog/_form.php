<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-orders-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameid')->textInput() ?>

    <?= $form->field($model, 'distributor')->textInput() ?>

    <?= $form->field($model, 'orderid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'distributorOrderid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'player_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gameRoleid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gameRoleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gameServerId')->textInput() ?>

    <?= $form->field($model, 'gameAccount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput() ?>

    <?= $form->field($model, 'vcoinRatio')->textInput() ?>

    <?= $form->field($model, 'paymoney')->textInput() ?>

    <?= $form->field($model, 'payTime')->textInput() ?>

    <?= $form->field($model, 'orderTime')->textInput() ?>

    <?= $form->field($model, 'deviceId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isDebug')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
