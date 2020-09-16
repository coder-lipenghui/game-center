<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersPretestSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-orders-pretest-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'distributionId')->label("渠道ID") ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'distributionUserId')->label("渠道账号") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'rcvRoleName')->label("角色名") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'rcvServerId')->label("区服ID") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?php  echo $form->field($model, 'got')->label("领取状态") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'rcvRoleId')->label("角色ID") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'type')->label("返利类型") ?>
        </div>
        <div class="col-md-3">
        </div>
    </div>

    <?//= $form->field($model, 'id') ?>
    <?//= $form->field($model, 'total') ?>
    <?//= $form->field($model, 'rate') ?>











    <?php // echo $form->field($model, 'rcvTime') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', '重置'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
