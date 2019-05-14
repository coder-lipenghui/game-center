<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabDistributionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-distribution-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'platform') ?>

    <?= $form->field($model, 'distributorId') ?>

    <?= $form->field($model, 'parentDT') ?>

    <?php // echo $form->field($model, 'centerLoginKey') ?>

    <?php // echo $form->field($model, 'centerPaymentKey') ?>

    <?php // echo $form->field($model, 'appID') ?>

    <?php // echo $form->field($model, 'appKey') ?>

    <?php // echo $form->field($model, 'appLoginKey') ?>

    <?php // echo $form->field($model, 'appPaymentKey') ?>

    <?php // echo $form->field($model, 'appPublicKey') ?>

    <?php // echo $form->field($model, 'enabled') ?>

    <?php // echo $form->field($model, 'isDebug') ?>

    <?php // echo $form->field($model, 'api') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
