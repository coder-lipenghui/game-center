<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cdn-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'versionId')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\TabGameVersion::find()->select(['id','name'])->asArray()->all(),'id','name')) ?>

    <?= $form->field($model, 'gameId')->textInput()->label("游戏") ?>

    <?= $form->field($model, 'updateUrl')->textInput(['maxlength' => true])->label("热更地址") ?>

    <?= $form->field($model, 'assetsUrl')->textInput(['maxlength' => true])->label("分包地址") ?>

    <?= $form->field($model, 'platform')->dropDownList(['tencent'=>"腾讯云",'aliyun'=>'阿里云','huawei'=>'华为云','jinsha'=>'金山云'],['maxlength' => true])->label("服务器运营商") ?>

    <?= $form->field($model, 'secretId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'secretKey')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
