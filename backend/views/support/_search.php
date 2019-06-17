<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabSupporSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-suppor-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sponsor') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'distributorId') ?>

    <?= $form->field($model, 'serverId') ?>

    <?php // echo $form->field($model, 'roleAccount') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'verifier') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
