<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\TabGames;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model backend\models\TabServers */

$this->title = Yii::t('app', '新增区服');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '区服管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//TODO 引入一个server.js 动态获取distribution的id【两个：安卓、ios】
//TODO 处理select2的字符串问题
//TODO 这个做完了之后就去做登录接口
?>
<div class="tab-servers-create">
    <?php Pjax::begin(['id' => 'new_country']) ?>
    <?php $form = ActiveForm::begin([
        'options' => ['data-pjax' => true ]
    ]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            基础信息
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
                <div class="col-md-2">
                    <?= $form->field($model, 'distributions')->widget(Select2::classname(), [
                        'data' => [],
                        'options' => [
                            'placeholder' => '分销渠道',
                            'multiple' => true,
                        ],
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <?= $form->field($model, 'index')->textInput(['placeholder' => '显示ID']) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => '显示名称']) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'status')->textInput(['placeholder' => '状态']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true,'placeholder' => '区服域名 例:t1.qiyou.com']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'openDateTime')->textInput() ?>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            数据库端口
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'smallDbPort')->textInput(['placeholder'=>'数据库小端口 例:3310']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'bigDbPort')->textInput(['placeholder'=>'数据库大端口 例:3311']) ?>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            网络通信端口
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'netPort')->textInput(['placeholder'=>'Net端口 例:7810']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'masterPort')->textInput(['placeholder'=>'Master端口 例:8310']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'contentPort')->textInput(['placeholder'=>'content端口 例:8311']) ?>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            其他
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'createTime')->textInput() ?>
                </div>
                <div class="col-md-2">

                    <?= $form->field($model, 'mergeId')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <?= Html::submitButton(Yii::t('app', '确认新增'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>
</div>
