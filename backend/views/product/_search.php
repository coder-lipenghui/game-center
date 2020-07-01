<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id')->dropDownList($games) ?>

    <?= $form->field($model, 'gameId') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'productId') ?>

    <?= $form->field($model, 'productName') ?>

    <?php // echo $form->field($model, 'productPrice') ?>

    <?php // echo $form->field($model, 'productScript') ?>

    <?php // echo $form->field($model, 'enable') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
