<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdnSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cdn-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'updateUrl') ?>

    <?= $form->field($model, 'assetsUrl') ?>

    <?= $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'secretId') ?>

    <?php // echo $form->field($model, 'secretKey') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
