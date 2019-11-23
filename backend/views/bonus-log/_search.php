<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabBonusLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-bonus-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'distributorId') ?>

    <?= $form->field($model, 'orderId') ?>

    <?= $form->field($model, 'addBindAmount') ?>

    <?php // echo $form->field($model, 'addUnbindAmount') ?>

    <?php // echo $form->field($model, 'logTime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
