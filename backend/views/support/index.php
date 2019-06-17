<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use backend\models\TabPermission;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabSupporSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '扶持管理');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/common.js');
$this->registerJsFile('@web/js/support.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJs('
    $("#submitSupport").on("pjax:success", function(data, status, xhr, options) {
        $("#myModal").modal("toggle");
        alert(data);
    });
');

?>
<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">扶持申请</h4>
            </div>
            <div class="modal-body">
                <?php
                    $form=ActiveForm::begin([
                        'id'=>'createSupportForm',
                        'fieldConfig' => ['template' => '{input}'],
                        'class'=>'form-inline'
                    ]);
                ?>
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <p class="text-info">非充值类型:金钻/元宝通过邮件形式发放，不算充值积分</p>
                    <p class="text-info">充值类型：模拟充值发放,记录充值积分等，玩家可以领取常规充值奖励等</p>
                    <p class="text-info">绑定元宝/金钻需要填写角色名，模拟充值类型的需要填写账号.</p>
                </div>
                <table class="table table-condensed" style="table-layout: fixed;">
                    <tr>
                        <td width="100">基础:</td>
                        <td>
                            <div class="row">
                                <div class="col-md-3"><?=$form->field($createModel,'gameId')->dropDownList(
                                        $games,
                                        [
                                            "class"=>"selectpicker form-control col-xs-2",
                                            "data-width"=>"fit",
                                            "id"=>"games",
                                            "onchange"=>"changeGame(this)",
                                            "title"=>"选择游戏"
                                        ]
                                    )?></div ≤>
                                <div class="col-md-3"><?=$form->field($createModel,'distributorId')->dropDownList(
                                        [],
                                        [
                                            "class"=>"selectpicker form-control col-xs-2",
                                            "data-width"=>"fit",
                                            "id"=>"distributors",
                                            "onchange"=>"changeDistributor(this)",
                                            "title"=>"分销商"
                                        ]
                                    )?></div>
                                <div class="col-md-3"><?=$form->field($createModel,'serverId')->dropDownList(
                                        [],
                                        [
                                            "class"=>"selectpicker form-control col-xs-2",
                                            "data-width"=>"fit",
                                            "id"=>"servers",
                                            "title"=>"选择区服"
                                        ]
                                    )?></div>
                                <div class="col-md-3"><?=$form->field($createModel,'type')->dropDownList(
                                        [0=>"非充值",1=>"充值"],
                                        [
                                            "class"=>"selectpicker form-control col-xs-2",
                                            "data-width"=>"fit",
                                            "id"=>"supportType",
                                            "title"=>"类型",
                                            "onchange"=>"changeType()"
                                        ]
                                    )?></div>
                            </div>
                        </td>
                    </tr>
                    <tr id="roleAccount">
                        <td>角色账号:</td>
                        <td><?= $form->field($createModel,'roleAccount')->textInput(['value'=>'01e73c5313d22f98d5e84702c37360d4'])?></td>
                    </tr>
                    <tr id="roleName">
                        <td>角色名称:</td>
                        <td><?= $form->field($createModel,'roleName')->textInput(['value'=>'辉哥啊'])?></td>
                    </tr>
                    <tr>
                        <td>申请理由:</td>
                        <td><?= $form->field($createModel,'reason')->textInput(['value'=>'测试'])?></td>
                    </tr>
                    <tr>
                        <td>申请数量:</td>
                        <td><?= $form->field($createModel,'number')->textInput()?></td>
                    </tr>
                </table>
            </div>
            <?php
                ActiveForm::end();
            ?>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success" onclick="createSupport()">申请</button>
            </div>
        </div>
    </div>
</div>

<div class="tab-suppor-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                新增扶持
            </button>
        </div>
    </div>
    <div class="panel panel-default">

        <div class="panel-body">
            <?php
            $searchForm=ActiveForm::begin([
                'id'=>'searchForm',
                'class'=>'form-inline',
                'fieldConfig' => ['template' => '{input}'],
                'action' => ['index'],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
            ]);
            ?>
            <div class="row">
                <div class="col-md-1"><?=$searchForm->field($createModel,'gameId')->dropDownList(
                        $games,
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"games",
                            "onchange"=>"changeGame(this)",
                            "title"=>"选择游戏"
                        ]
                    )?></div>
                <div class="col-md-1"><?=$searchForm->field($createModel,'distributorId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"distributors",
                            "onchange"=>"changeDistributor(this)",
                            "title"=>"分销商"
                        ]
                    )?></div>
                <div class="col-md-1"><?=$searchForm->field($createModel,'serverId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"servers",
                            "title"=>"选择区服"
                        ]
                    )?></div>
                <div class="col-md-1">
                    <?=$searchForm->field($createModel,'type')->dropDownList(
                        [0=>"非充值",1=>"充值"],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"supportType",
                            "title"=>"类型",
                            "onchange"=>"changeType()"
                        ]
                    )?>
                </div>
                <div class="col-md-1">
                    <?php
                    echo Html::submitButton("查询",["class"=>"btn btn-primary"]);
                    ?>
                </div>
            </div>
            <?php
                ActiveForm::end();
            ?>
            <?php Pjax::begin(); ?>
            <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//                    'sponsor',
//                    'gameId',
//                    'distributorId',
                    [
                        'attribute'=>'serverId',
                        'value'=>function($model){
                            return $model->server->name."($model->serverId)";
                        }
                    ],
                    'roleAccount',
                    'reason',
                    [
                        'attribute'=>'type',
                        'label'=>'扶持类型',
                        'format'=>'html',
                        'value'=>function($model){
                            $class="primary";
                            $type="无充值积分";
                            if ($model->type==1)
                            {
                                $class="info";
                                $type="有充值积分";
                            }
                            return '<span class="label label-'.$class.'">'.$type.'</span>';
                        }
                    ],
                    'number',
                    [
                        'attribute'=>'deliver',
                        'value'=>function($model){
                            $deliver="";
                            switch ($model->deliver)
                            {
                                case 0:
                                    break;
                                case 1:
                                    $deliver="失败";
                                    break;
                                case 2:
                                    $deliver="成功";
                                    break;
                            }
                            return $deliver;
                        }
                    ],
                    [
                        'attribute'=>'status',
                        'label'=>'审核',
                        'format'=>'html',
                        'value'=>function($model){
                            $status="未知";
                            $class="default";
                            switch ($model->status)
                            {
                                case 0:
                                    $status="未审核";
                                    $class="default";
                                    break;
                                case 1:
                                    $status="已通过";
                                    $class="success";
                                    break;
                                case 2:
                                    $status="不通过";
                                    $class="danger";
                                    break;
                            }
                            return '<span class="label label-'.$class.'">'.$status.'</span>';
                        }
                    ],
                    [
                        'label'=>'操作',
                        'class' => 'common\components\ActionColumn',
                        'template' => "{:allow} {:refuse} {:delete}",
                        'buttons' => [
                            'refuse' => function ($url, $model, $key) {
                                $permission=TabPermission::find()->where(['uid'=>\Yii::$app->user->id,'gameId'=>$model->gameId,'distributorId'=>$model->distributorId,'support'=>1])->one();
                                $options = [];
                                if ($permission && $model->status==0)
                                {
                                    return Html::a('<button type="button" class="btn btn-warning btn-sm">拒绝</button>',$url, $options);
                                }
                                return "";
                            },
                            'allow' => function ($url, $model, $key) {
                                $options = [];
                                $permission=TabPermission::find()->where(['uid'=>\Yii::$app->user->id,'gameId'=>$model->gameId,'distributorId'=>$model->distributorId,'support'=>1])->one();
                                $options = [];
                                if ($permission && ($model->status!=1 || $model->deliver<2)) {
                                    return Html::a('<button type="button" class="btn btn-success btn-sm">同意</button>', $url, $options);
                                }
                                return "";
                            },
                            'delete' => function ($url, $model, $key) {
                                if ($model->status==0)
                                {
                                    $options = [
                                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                                    ];
                                    return Html::a('<button type="button" class="btn btn-danger btn-sm">删除</button>', $url, $options);
                                }
                            },
                        ]
                    ]
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
