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
//TODO 引入一个server.js 动态获取distribution的id【两个：安卓、ios】
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/server.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJs('
    $("document").ready(function(){ 
        $("#createServer").on("pjax:end", function() {
//            $.pjax.reload({container:"#createServerForm"});  //Reload GridView
        });
    });
');

//TODO 处理select2的字符串问题
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
                    <?php
                        $data=[['id'=>0,'name'=>'test'],['id'=>1,'name'=>'test1']];
                        echo Html::dropDownList('server_distributor',null,
                            ArrayHelper::map($data,'id', 'name'),
//                            [],
                            [
                                'id'=>'server_distributor',
                                'class'=>'selectpicker form-control col-xs-1',
                                'title'=>'分销商',
                            ]);
                    ?>
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
            分销渠道：
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8">
                    <?=
                    $form->field($model, 'distributions')->checkboxList(
                        [
//                            0=>'测试',1=>'测试',2=>'测试',3=>'测试',4=>'测试',5=>'测试',6=>'测试',7=>'测试',8=>'测试',9=>'测试',
//                            10=>'测试',11=>'测试',12=>'测试',13=>'测试',14=>'测试',15=>'测试',16=>'测试',17=>'测试',18=>'测试',19=>'测试',
//                            20=>'测试',21=>'测试',22=>'测试',23=>'测试',24=>'测试',25=>'测试',26=>'测试',27=>'测试',28=>'测试',29=>'测试',
//                            30=>'测试',31=>'测试',32=>'测试',33=>'测试',34=>'测试',35=>'测试',36=>'测试',37=>'测试',38=>'测试',39=>'测试',
//                            40=>'测试',41=>'测试',42=>'测试',43=>'测试',44=>'测试',45=>'测试',46=>'测试',47=>'测试',48=>'测试',49=>'测试',
//                            50=>'测试',51=>'测试',52=>'测试',53=>'测试',54=>'测试',55=>'测试',56=>'测试',57=>'测试',58=>'测试',59=>'测试',
//                            60=>'测试',61=>'测试',62=>'测试',63=>'测试',64=>'测试',65=>'测试',66=>'测试',67=>'测试',68=>'测试',69=>'测试',
//                            70=>'测试',71=>'测试',72=>'测试',73=>'测试',74=>'测试',75=>'测试',76=>'测试',77=>'测试',78=>'测试',79=>'测试',
//                            80=>'测试',81=>'测试',82=>'测试',83=>'测试',84=>'测试',85=>'测试',86=>'测试',87=>'测试',88=>'测试',89=>'测试',
//                            90=>'测试',91=>'测试',92=>'测试',93=>'测试',94=>'测试',95=>'测试',96=>'测试',97=>'测试',98=>'测试',99=>'测试',
                        ]
                    );
                    ?>
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
