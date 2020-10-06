<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabPlayersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-players-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'distributorId')->label("分销商") ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'gameId')->label("游戏") ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'distributionUserId')->label("分销用户ID") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'distributionUserAccount')->label("分销用户账号") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'account')->label("我方账号") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'regdeviceId')->label("设备ID") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'regip')->label("注册IP") ?>
        </div>
        <div class="col-md-3">
            <?php  echo $form->field($model, 'regtime')->label("注册时间") ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
