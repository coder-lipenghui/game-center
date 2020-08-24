<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkeyVariety */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cdkey-variety-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->dropDownList($versions)->label("选择版本") ?>

    <?= $form->field($model, 'type')->dropDownList([1=>'普通',2=>'通用'])->label("激活码类型") ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('激活码名称') ?>

    <?= $form->field($model, 'items')->textInput(['maxlength' => true])->label('激活码物品内容') ?>

    <?= $form->field($model, 'once')->dropDownList([0=>'否',1=>'是'])->label("只能使用一次") ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '确 定'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
