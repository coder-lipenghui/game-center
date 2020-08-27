<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabBlacklist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-blacklist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->dropDownList($games)->label("游戏") ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true])->label("登录IP") ?>

    <?= $form->field($model, 'distributionUserId')->textInput(['maxlength' => true])->label("渠道账号") ?>

    <?= $form->field($model, 'deviceId')->textInput(['maxlength' => true])->label("设备ID") ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '新 增'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
