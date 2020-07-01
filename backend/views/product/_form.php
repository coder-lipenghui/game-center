<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabProduct */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->dropDownList($games) ?>

    <?= $form->field($model, 'type')->dropDownList([0=>'类型',1=>'普通',2=>'脚本']) ?>

    <?= $form->field($model, 'productId')->textInput(['placeholder'=>'计费ID']) ?>

    <?= $form->field($model, 'productName')->textInput(['maxlength' => true,'placeholder'=>'计费名称']) ?>

    <?= $form->field($model, 'productPrice')->textInput(['placeholder'=>'单位:分']) ?>

    <?= $form->field($model, 'productScript')->textInput(['maxlength' => true,'placeholder'=>'脚本触发ID,脚本类型必填,否则无法到账']) ?>

    <?= $form->field($model, 'enable')->dropDownList([0=>'禁用',1=>'启用']) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
