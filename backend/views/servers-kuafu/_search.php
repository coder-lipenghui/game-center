<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabServersKuafuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-servers-kuafu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'versionId') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'index') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'netPort') ?>

    <?php // echo $form->field($model, 'masterPort') ?>

    <?php // echo $form->field($model, 'contentPort') ?>

    <?php // echo $form->field($model, 'smallDbPort') ?>

    <?php // echo $form->field($model, 'bigDbPort') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
