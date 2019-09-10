<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameAssets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-game-assets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributionId')->textInput() ?>

    <?= $form->field($model, 'versionFile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'projectFile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'executeTime')->textInput() ?>

    <?= $form->field($model, 'enable')->textInput() ?>

    <?= $form->field($model, 'svn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
