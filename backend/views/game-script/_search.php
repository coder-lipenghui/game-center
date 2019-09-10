<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameScriptSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-game-script-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'fileName') ?>

    <?= $form->field($model, 'fileSize') ?>

    <?= $form->field($model, 'userId') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'logTime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
