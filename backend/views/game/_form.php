<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGames */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-games-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'versionId')->textInput() ?>

    <?= $form->field($model, 'loginKey')->textInput() ?>

    <?= $form->field($model, 'paymentKey')->textInput() ?>

    <?= $form->field($model, 'createTime')->textInput() ?>

    <?= $form->field($model, 'mingleGameId')->textInput() ?>

    <?= $form->field($model, 'copyright_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'copyright_isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'copyright_press')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'copyright_author')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
