<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-orders-search">

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

    <?= $form->field($model, 'orderId') ?>

    <?= $form->field($model, 'distributorOrderId') ?>

    <?php // echo $form->field($model, 'playerId') ?>

    <?php // echo $form->field($model, 'gameRoleId') ?>

    <?php // echo $form->field($model, 'gameRoleName') ?>

    <?php // echo $form->field($model, 'gameServerId') ?>

    <?php // echo $form->field($model, 'gameAccount') ?>

    <?php // echo $form->field($model, 'goodName') ?>

    <?php // echo $form->field($model, 'payAmount') ?>

    <?php // echo $form->field($model, 'payStatus') ?>

    <?php // echo $form->field($model, 'payMode') ?>

    <?php // echo $form->field($model, 'payTime') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <?php // echo $form->field($model, 'delivered') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
