<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TabGames;
/* @var $this yii\web\View */
/* @var $model backend\models\TabSupporSearch */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile("@webroot/bootstrap-select/css/bootstrap-select.css")
?>

<div class="tab-suppor-search">

    <?php
//        exit(json_encode($distributors,JSON_UNESCAPED_UNICODE));
        $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-md-1">
            <?= $form->field($model, 'gameId')->dropDownList($games)
            ?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, 'distributorId')->dropDownList($distributors) ?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, 'serverId')->dropDownList($servers) ?>
        </div>
        <div class="col-md-1">
            <?php  echo $form->field($model, 'roleAccount') ?>
        </div>
        <div class="col-md-1">
            <?php  echo $form->field($model, 'reason') ?>
        </div>
        <div class="col-md-1">
            <?php  echo $form->field($model, 'type')->dropDownList([null=>'全部',0=>'非充值',1=>'算充值']) ?>
        </div>
        <div class="col-md-1">
            <?php  echo $form->field($model, 'number') ?>
        </div>
        <div class="col-md-1">
            <?php  echo $form->field($model, 'status')->dropDownList([0=>'未审核',1=>'已审核',2=>'已拒绝']) ?>
        </div>
        <div class="col-md-1">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
