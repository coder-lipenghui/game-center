<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabActionTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-action-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'actionId') ?>

    <?= $form->field($model, 'actionType') ?>

    <?= $form->field($model, 'actionName') ?>

    <?= $form->field($model, 'actionDesp') ?>

    <?php // echo $form->field($model, 'actionLua') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
