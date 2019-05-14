<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabLogLoginSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-log-login-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gameid') ?>

    <?= $form->field($model, 'distributor') ?>

    <?= $form->field($model, 'playerId') ?>

    <?= $form->field($model, 'ipAddress') ?>

    <?php // echo $form->field($model, 'deviceOs') ?>

    <?php // echo $form->field($model, 'deviceVender') ?>

    <?php // echo $form->field($model, 'deviceId') ?>

    <?php // echo $form->field($model, 'deviceType') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <?php // echo $form->field($model, 'loginKey') ?>

    <?php // echo $form->field($model, 'token') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
