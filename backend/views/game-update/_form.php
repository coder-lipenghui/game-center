<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TabGames;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\TabGameUpdate */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile("@web/js/common.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/gameUpdate.js",['depends'=>'yii\web\YiiAsset']);
?>

<div class="tab-game-update-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->dropDownList(
            ArrayHelper::map(TabGames::find()->select(['id','name'])->all(),'id','name'),
            [
                'id'=>'gameUpdateGames',
                'onchange'=>'handleGameChange()'
            ]) ?>

    <?= $form->field($model, 'distributionId')->dropDownList([],
        [
            'id'=>'gameUpdateDistributions'
        ]) ?>

    <?= $form->field($model, 'versionFile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'projectFile')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'executeTime')->textInput() ?>

    <?= $form->field($model, 'enable')->textInput() ?>

    <?= $form->field($model, 'svn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
