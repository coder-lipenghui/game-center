<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabBonus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-bonus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributorId')->textInput() ?>

    <?= $form->field($model, 'bindAmount')->textInput() ?>

    <?= $form->field($model, 'unbindAmount')->textInput() ?>

    <?= $form->field($model, 'bindRatio')->textInput() ?>

    <?= $form->field($model, 'unbindRatio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
