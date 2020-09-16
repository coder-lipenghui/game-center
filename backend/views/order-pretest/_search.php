<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersPretestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-orders-pretest-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'distributionId') ?>

    <?= $form->field($model, 'distributionUserId') ?>

    <?= $form->field($model, 'total') ?>

    <?= $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'got') ?>

    <?php // echo $form->field($model, 'rcvRoleId') ?>

    <?php // echo $form->field($model, 'rcvRoleName') ?>

    <?php // echo $form->field($model, 'rcvServerId') ?>

    <?php // echo $form->field($model, 'rcvTime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
