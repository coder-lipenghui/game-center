<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkeyRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cdkey-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'distributionId') ?>

    <?= $form->field($model, 'account') ?>

    <?= $form->field($model, 'serverId') ?>

    <?php // echo $form->field($model, 'roleId') ?>

    <?php // echo $form->field($model, 'roleName') ?>

    <?php // echo $form->field($model, 'cdkey') ?>

    <?php // echo $form->field($model, 'logTime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
