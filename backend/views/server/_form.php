<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabServers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-servers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'index')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'netPort')->textInput() ?>

    <?= $form->field($model, 'masterPort')->textInput() ?>

    <?= $form->field($model, 'contentPort')->textInput() ?>

    <?= $form->field($model, 'smallDbPort')->textInput() ?>

    <?= $form->field($model, 'bigDbPort')->textInput() ?>

    <?= $form->field($model, 'mergeId')->textInput() ?>

    <?= $form->field($model, 'openDateTime')->textInput() ?>

    <?= $form->field($model, 'createTime')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
