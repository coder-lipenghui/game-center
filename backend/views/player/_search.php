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
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'distributionId') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'account') ?>

    <?= $form->field($model, 'distributionUserId') ?>

    <?php // echo $form->field($model, 'distributionUserAccount') ?>

    <?php // echo $form->field($model, 'regdeviceId') ?>

    <?php // echo $form->field($model, 'regtime') ?>

    <?php // echo $form->field($model, 'regip') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
