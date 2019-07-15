<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabNoticeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '合区');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("@web/js/common.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/ops/merge.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJs('
    handleGameChange();
');
?>
<div class="tab-notice-index">
    <div class="tab-orders-index">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="alert alert-info" id="msgBox">
                    <label class="text-info" id="msgBoxText">合区操作</label>
                    <ul class="text-info hidden" >
                        <li>merger_pre.php:注释掉20-25的更改中控区服状态的代码</li>
                        <li>hequ_client.php
                            <ul>
                                <li>fscoket处增加 error_reporting(E_ALL ^ E_WARNING);  规避掉警告</li>
                                <li>约136行的错误返回修改:exitmsg('false', 'local file exists error05');</li>
                                <li>约142行的错误返回修改:exitmsg('false', 'extract zip error');</li>
                                <li>约143行的错误返回修改:exitmsg('false', 'unlink file error05');</li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <?php
                $form=ActiveForm::begin([
                    "id"=>"myform",
                    "method"=>"get"
                ]);
                ?>
                <table class="table table-condensed">
                    <tr>
                        <td class="col-md-1">游戏</td>
                        <td>
                            <?=$form->field($searchModel,'gameId')->dropDownList(
                                $games,
                                [
                                    "class"=>"selectpicker form-control col-md-1",
                                    "data-width"=>"fit",
                                    "id"=>"mergeGames",
                                    "onchange"=>"handleGameChange()",
                                    "title"=>"选择游戏"
                                ]
                            )->label(false)?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>分销商</td>
                        <td>
                            <?=$form->field($searchModel,'distributorId')->dropDownList(
                                [],
                                [
                                    "class"=>"selectpicker form-control col-xs-2",
                                    "data-width"=>"fit",
                                    "id"=>"mergeDistributors",
                                    "onchange"=>"handleDistributorChange()",
                                    "title"=>"分销商"
                                ]
                            )->label(false)?>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>操作</td>
                        <td>
                            <div class="form-inline">
                                <?=$form->field($searchModel,'activeServerId')->dropDownList(
                                    [],
                                    [
                                        "class"=>"selectpicker form-control col-xs-2",
                                        "data-width"=>"fit",
                                        "id"=>"targetServer",
                                        "title"=>"主动区"
                                    ]
                                )->label(false);?>
                                <label>合至</label>
                                <?=$form->field($searchModel,'passiveServerId')->dropDownList(
                                    [],
                                    [
                                        "class"=>"selectpicker form-control col-xs-2",
                                        "data-width"=>"fit",
                                        "id"=>"sourceServer",
                                        "title"=>"被动区"
                                    ]
                                )->label(false);?>
                            </div>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>模式</td>
                        <td><?=$form->field($searchModel,'type')->radioList([0=>'半自动',1=>'全自动'],['onclick'=>'handlerChangeType()'])->label(false);?></td>
                        <td>

                        </td>
                    </tr>
                    <tr class="hidden" id="operationTr">
                        <td>半自动</td>
                        <td>
                            <?php
                                echo Html::dropDownList(
                                    "operation",
                                    [],
                                    [1=>'打包数据',2=>'合并数据',3=>'处理重名'],
                                    [
                                        'id'=>'operation',
                                        "class"=>"selectpicker form-control col-md-1",
                                        "data-width"=>"fit",
                                    ]
                                );
                            ?>
                        </td>
                        <td></td>
                    </tr>
                </table>
                <?php
                    ActiveForm::end();
                ?>
                    <button class="btn btn-success" id="btnSubmit" onclick="doMerge(this)">确认合区</button>
            </div>
        </div>
    </div>
</div>
