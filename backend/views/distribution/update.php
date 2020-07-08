<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\TabGames;
use backend\models\TabDistributor;
/* @var $this yii\web\View */
/* @var $model backend\models\TabDistribution */

$this->title = Yii::t('app', '更新渠道信息: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '分销渠道管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tab-distribution-update">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            研发配置信息：
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-1">
                    <?= $form->field($model, 'gameId')->dropDownList(
                        ArrayHelper::map(TabGames::find()->asArray()->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "title"=>"选择游戏"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'distributorId')->dropDownList(
                        ArrayHelper::map(TabDistributor::find()->asArray()->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "title"=>"选择分销商"
                        ]
                    )->label("分销商") ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'parentDT')->dropDownList(
                        ArrayHelper::map(TabDistributor::find()->asArray()->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "title"=>"选择分销商"
                        ]

                    )->label("父级分销商") ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'platform')->dropDownList(
                        [
                            1=>'安卓',2=>'IOS'
                        ],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "title"=>"设备平台"
                        ]
                    )->label("平台") ?>
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
                <div class="col-md-1">
                    <?= $form->field($model, 'ratio')->textInput(['maxlength' => true,'value'=>100]) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'rebate')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            包信息：
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'packageName')->textInput(['maxlength' => true,'placeholder'=>'例:com.xxdweb.demo'])->label("应用ID(ApplicationID)") ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'versionCode')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'versionName')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

        </div>
        <div class="panel-heading">
            分销渠道参数：
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'appID')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'appKey')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'appLoginKey')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'appPaymentKey')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'appPublicKey')->textarea(['rows' => 6,'placeholder'=>'常规填写RSA类型的KEY']) ?>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            其他：其他：(中控controller id用于安卓打包时的channel，例:<b>quick</b>,则login url信息为:center.xxdweb.com/center/<b>quick</b>/login)
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'api')->textInput(['maxlength' => true,'placeholder'=>'区分同一家分销商可能存在多个SDK的情况，只做展示']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', '确认修改'), ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
