<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TabGames;
use backend\models\TabDistributor;
use backend\models\TabGameVersion;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkey */

$this->title = Yii::t('app', '生成激活码');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '激活码管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/cdk.js',['depends'=>'yii\web\YiiAsset']);
?>
<div class="tab-cdkey-create">
    <div class="panel panel-default">
        <?php $form = ActiveForm::begin([
            'id'=>'cdkeyGenerate'
        ]); ?>

        <div class="panel-body">
            <div id="alertDiv">
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'gameId')->dropDownList(
                        ArrayHelper::map(TabGameVersion::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListVersion",
                            "title"=>"选择版本",
                            "onchange"=>"handleVersionChange()",
                        ]
                    )->label("版本") ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'varietyId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListCDKEYVariety",
                            "onchange"=>"handleVarietyChange()",
                            "title"=>"激活码分类"
                        ]
                    ) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'gameId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListGame",
                            "title"=>"选择游戏",
                            "onchange"=>"handleGameChange()"
                        ]
                    ) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'distributorId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListDistributor",
                            "title"=>"分销商"
                        ]
                    ) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'generateNum')->textInput(['placeholder'=>'生成数量,最大10万','id'=>'generateNum'])->label("生成数量") ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 hidden">
                    <?= $form->field($model, 'distributionId')->textInput(['placeholder'=>'分销渠道可选']) ?>
                </div>
                <div class="col-md-2 hidden" id="cdkeyInput">
                    <?= $form->field($model, 'cdkey')->textInput(['maxlength' => true,'value'=>'自动生成','id'=>'cdkey']) ?>
                </div>
                <div class="col-md-2 hidden">
                    <?= $form->field($model, 'createTime')->textInput(['value'=>time()]) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="btn btn-success" onclick="handleGenerate()">确认生成</div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
