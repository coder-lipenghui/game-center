<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ops\TabOpsMergeLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-ops-merge-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'distributionId') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'activeUrl') ?>

    <?= $form->field($model, 'passiveUrl') ?>

    <?php // echo $form->field($model, 'logTime') ?>

    <?php // echo $form->field($model, 'uid') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
