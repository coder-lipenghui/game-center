<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabLogRoleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-log-role-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'loginKey') ?>

    <?= $form->field($model, 'token') ?>

    <?= $form->field($model, 'roleId') ?>

    <?= $form->field($model, 'roleName') ?>

    <?php // echo $form->field($model, 'roleLevel') ?>

    <?php // echo $form->field($model, 'zoneId') ?>

    <?php // echo $form->field($model, 'zoneName') ?>

    <?php // echo $form->field($model, 'ctime') ?>

    <?php // echo $form->field($model, 'distId') ?>

    <?php // echo $form->field($model, 'sku') ?>

    <?php // echo $form->field($model, 'createtime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
