<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersRebate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-orders-rebate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributorId')->textInput() ?>

    <?= $form->field($model, 'distributionId')->textInput() ?>

    <?= $form->field($model, 'orderId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'distributionOrderId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'distributionUserId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gameRoleId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gameRoleName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gameServerId')->textInput() ?>

    <?= $form->field($model, 'gameServername')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gameAccount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'productId')->textInput() ?>

    <?= $form->field($model, 'productName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payAmount')->textInput() ?>

    <?= $form->field($model, 'payStatus')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'payMode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payTime')->textInput() ?>

    <?= $form->field($model, 'createTime')->textInput() ?>

    <?= $form->field($model, 'delivered')->dropDownList([ '0', '1', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
