<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TabGames;
use backend\models\TabDistributor;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkey */

$this->title = Yii::t('app', '生成激活码');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '激活码管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cdkey-create">
    <div class="panel panel-default">
        <div class="panel-heading">
            基础条件
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-1">
                    <?= $form->field($model, 'gameId')->dropDownList(
                        ArrayHelper::map(TabGames::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListGame",
                            "title"=>"选择游戏"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'distributorId')->dropDownList(
                        ArrayHelper::map(TabDistributor::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListDistributor",
                            "title"=>"分销商"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'varietyId')->dropDownList(
                        ArrayHelper::map(\backend\models\TabCdkeyVariety::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListCDKEYVariety",
                            "title"=>"激活码分类"
                        ]
                    ) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'generateNum')->textInput(['placeholder'=>'生成数量,最大10万']) ?>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            其他
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'distributionId')->textInput(['placeholder'=>'分销渠道可选']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'cdkey')->textInput(['maxlength' => true,'value'=>'系统会自动生成唯一CDKEY']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'createTime')->textInput(['value'=>time()]) ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', '确认生成'), ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
