<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\TabDistribution */

$this->title = Yii::t('app', '更新渠道信息: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '分销渠道管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'gameId')->textInput() ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'platform')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'distributorId')->textInput() ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'parentDT')->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'centerLoginKey')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'centerPaymentKey')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'appID')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'appKey')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($model, 'appLoginKey')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'appPaymentKey')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'appPublicKey')->textarea(['rows' => 6]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-1">
                <?= $form->field($model, 'enabled')->dropDownList(
                    [0=>"禁用",1=>"启用"]
                ) ?>
            </div>
            <div class="col-md-1">
                <?= $form->field($model, 'isDebug')->dropDownList(
                    [0=>"已完成",1=>"测试中"]
                ) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'api')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', '确认修改'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
</div>
