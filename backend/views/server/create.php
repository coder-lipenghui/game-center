<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\models\TabGames;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\widgets\Pjax;
use yii\web\JsExpression;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Dropdown;
/* @var $this yii\web\View */
/* @var $model backend\models\TabServers */

$this->title = Yii::t('app', '新增区服');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '区服管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/server.js',['depends'=>'yii\web\YiiAsset']);
?>
<div class="tab-servers-create">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => ['template' => '{input}'],
    ]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            基础信息
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-1">
                    <?= $form->field($model, 'gameId')->dropDownList(
                        $games,
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "title"=>"选择游戏",
                            "id"=>"server_game",
                            "onchange"=>"getDist()"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'distributorId')->dropDownList(
                        $games,
                        [
                            "class"=>"selectpicker form-control col-xs-1",
                            "data-width"=>"fit",
                            "title"=>"分销商",
                            "id"=>"server_distributor",
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'index')->textInput(['placeholder' => '区服ID']) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder' => '区服名称']) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'status')->textInput(['placeholder' => '状态']) ?>
                </div>
            </div>
        </div>
        <div class="panel-heading">
            域名：
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true,'placeholder' => '区服域名 例:t1.qiyou.com']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'openDateTime')->widget(DateTimePicker::classname(), [
//                        'removeButton' => false,
                        'options' => [
                            'placeholder' => '开区时间'
                        ],

                        'pluginOptions' => [
                            'format'=>'yyyy-mm-dd h:i:00',
                            'autoclose' => true,
                            'startView'=>2,
                            'maxView'=>3,  //最大选择范围（年）
                            'minView'=>0,  //最小选择范围（年）
                        ]
                    ]);?>
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
            网络通信端口：
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
                    <?= $form->field($model, 'createTime')->widget(DateTimePicker::classname(), [
                        'removeButton' => false,
                        'options' => [
                            'value'=>date('Y-m-d h:i',time()),
                            'placeholder' => '创建时间'
                        ],
                        'pluginOptions' => [
                            'format'=>'yyyy-mm-dd h:i:00',
                            'autoclose' => true,
                            'startView'=>2,
                            'maxView'=>3,  //最大选择范围（年）
                            'minView'=>0,  //最小选择范围（年）
                        ]
                    ]);?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'mergeId')->textInput(['placeholder'=>'合区后的主区ID,server表的id']) ?>
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
</div>
