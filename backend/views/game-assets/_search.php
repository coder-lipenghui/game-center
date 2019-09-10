<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameAssetsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-game-assets-search">

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

    <?= $form->field($model, 'versionFile') ?>

    <?= $form->field($model, 'projectFile') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'executeTime') ?>

    <?php // echo $form->field($model, 'enable') ?>

    <?php // echo $form->field($model, 'svn') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
