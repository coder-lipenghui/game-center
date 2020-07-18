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
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'gameId')->label("游戏ID") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'distributionUserId')->label("渠道用户") ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'distributionOrderId')->label("渠道订单") ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-3">
            <?php  echo $form->field($model, 'gameServerId')->label("区服ID") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'gameRoleName')->label("角色名称") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'gameRoleId')->label("角色ID") ?>
        </div>

    </div>
    <div class="row">

        <div class="col-md-3">
            <?= $form->field($model, 'orderId')->label("我方订单号") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'payStatus')->label("支付状态") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'payAmount')->label("付费金额") ?>
        </div>
    </div>
<!--    --><?//= $form->field($model, 'id') ?>
    <?php // echo $form->field($model, 'gameAccount') ?>

    <?php // echo $form->field($model, 'productName') ?>



    <?php // echo $form->field($model, 'payStatus') ?>

    <?php // echo $form->field($model, 'payMode') ?>

    <?php // echo $form->field($model, 'payTime') ?>

    <?php // echo $form->field($model, 'createTime') ?>

    <?php // echo $form->field($model, 'delivered') ?>
    <?php // echo $form->field($model, 'gameServername')->label("区服名称") ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
<!--        --><?//= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
