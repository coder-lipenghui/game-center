<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TabItemdefDzy;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkeyVariety */

$this->title = Yii::t('app', '新增激活码种类');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '激活码种类管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/api/mail.js',['depends'=>'yii\web\YiiAsset']);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'种类名称']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'items')->dropDownList(
                    ArrayHelper::map(TabItemdefDzy::find()->select(['id','name'])->asArray()->all(),'id','name'),
                    [
                        "id"=>"selectItems",
                        "class"=>"selectpicker",
                        "data-live-search"=>"true",
                    ]
                ) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <?= $form->field($model, 'once')->dropDownList(
                        [0=>"是",1=>"否"]
                ) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', '确 认'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
