<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TabGames;
use backend\models\TabDistributor;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\TabDistribution */

$this->title = Yii::t('app', '新增分销渠道');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '分销渠道'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-distribution-create">

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
                    )->label('游戏') ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'distributorId')->dropDownList(
                        ArrayHelper::map(TabDistributor::find()->asArray()->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "title"=>"选择分销商"
                        ]
                    )->label('分销商') ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'parentDT')->dropDownList(
                        ArrayHelper::map(TabDistributor::find()->asArray()->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "title"=>"选择分销商"
                        ]

                    )->label('分销渠道') ?>
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
                    ) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'centerLoginKey')->textInput(['maxlength' => true,'value'=>'KOSD6PXtEkb0fRj@Ce7evfltKCMo568S'])->label('API登录KEY') ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'centerPaymentKey')->textInput(['maxlength' => true,'value'=>'MkH3!9f*KW1BguWS6cOEzn1EPq%TRA'])->label('API支付KEY') ?>
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
                    <?= $form->field($model, 'ratio')->textInput(['maxlength' => true,'value'=>100]) ?>

                </div>
            </div>
        </div>
        <div class="panel-heading">
            混服模式(可选)
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'mingleDistributionId')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'mingleServerId')->textInput()?>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            分销商提供的游戏参数：
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'appID')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'appKey')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'appLoginKey')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'appPaymentKey')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'appPublicKey')->textarea(['rows' => 6,'placeholder'=>'常规填写RSA类型的KEY']) ?>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            其他：
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'api')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-10">
                    区分同一家分销商可能存在多个SDK的情况，只做展示用
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?= Html::submitButton(Yii::t('app', '确认添加'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
