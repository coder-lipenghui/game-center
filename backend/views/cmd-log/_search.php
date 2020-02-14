<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCmdLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cmd-log-search">

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

    <?= $form->field($model, 'serverId') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'cmdName') ?>

    <?php // echo $form->field($model, 'cmdInfo') ?>

    <?php // echo $form->field($model, 'operator') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'result') ?>

    <?php // echo $form->field($model, 'logTime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
