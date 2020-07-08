<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabServerNaming */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/server.js',['depends'=>'yii\web\YiiAsset']);
?>

<div class="tab-server-naming-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->dropDownList($games,[
        "class"=>"selectpicker form-control col-xs-2",
        "data-width"=>"fit",
        "title"=>"选择游戏",
        "id"=>"server_game",
        "onchange"=>"getDist()"
    ]) ?>

    <?= $form->field($model, 'distributorId')->dropDownList([],
        [
        "class"=>"selectpicker form-control col-xs-1",
        "data-width"=>"fit",
        "title"=>"分销商",
        "id"=>"server_distributor",
    ]) ?>

    <?= $form->field($model, 'distributionId')->textInput(['placeholder'=>'可选，当ios跟android不混服时使用']) ?>

    <?= $form->field($model, 'serverId')->textInput()?>

    <?= $form->field($model, 'naming')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
