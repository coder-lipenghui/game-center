<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/kuafu.js',['depends'=>'yii\web\YiiAsset']);
/* @var $this yii\web\View */
/* @var $model backend\models\TabServersKuafu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-servers-kuafu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'versionId')->dropDownList(array_merge([0=>'选择版本'],$versions),['id'=>'versions',"onchange"=>"getGames()"]) ?>

    <?= $form->field($model, 'gameId')->dropDownList([],['id'=>'kuafuGames']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'index')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'netPort')->textInput() ?>

    <?= $form->field($model, 'masterPort')->textInput() ?>

    <?= $form->field($model, 'contentPort')->textInput() ?>

    <?= $form->field($model, 'smallDbPort')->textInput() ?>

    <?= $form->field($model, 'bigDbPort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
