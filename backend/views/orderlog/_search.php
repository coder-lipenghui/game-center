<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-orders-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gameid') ?>

    <?= $form->field($model, 'distributor') ?>

    <?= $form->field($model, 'orderid') ?>

    <?= $form->field($model, 'distributorOrderid') ?>

    <?php // echo $form->field($model, 'player_id') ?>

    <?php // echo $form->field($model, 'gameRoleid') ?>

    <?php // echo $form->field($model, 'gameRoleName') ?>

    <?php // echo $form->field($model, 'gameServerId') ?>

    <?php // echo $form->field($model, 'gameAccount') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'vcoinRatio') ?>

    <?php // echo $form->field($model, 'paymoney') ?>

    <?php // echo $form->field($model, 'payTime') ?>

    <?php // echo $form->field($model, 'orderTime') ?>

    <?php // echo $form->field($model, 'deviceId') ?>

    <?php // echo $form->field($model, 'isDebug') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
