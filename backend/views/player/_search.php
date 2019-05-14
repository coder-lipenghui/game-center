<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabPlayersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-players-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'distributor') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'distributorPlayerId') ?>

    <?= $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'uniqueKey') ?>

    <?php // echo $form->field($model, 'regdeviceId') ?>

    <?php // echo $form->field($model, 'regtime') ?>

    <?php // echo $form->field($model, 'regip') ?>

    <?php // echo $form->field($model, 'totalrecharge') ?>

    <?php // echo $form->field($model, 'rechargetimes') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
