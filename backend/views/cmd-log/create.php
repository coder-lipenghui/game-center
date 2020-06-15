<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\TabCmdLog */

$this->title = '执行GM命令';//Yii::t('app', 'Create Tab Cmd Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'GM命令记录'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/common.js');
$this->registerJsFile('@web/js/cmd.js',['depends'=>'yii\web\YiiAsset']);
$cmdInfo=\backend\models\TabCmd::find()->select(['id','shortName','comment'])->asArray()->all();
?>
<div class="tab-cmd-log-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <?php $form = ActiveForm::begin(); ?>
                <div class="col-md-1"><?=$form->field($model,'gameId')->dropDownList(
                        $games,
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"games",
                            "onchange"=>"changeGame(this,'#distributors')",
                            "label"=>"选择游戏"
                        ]
                    )->label(false)?>
                </div>
                <div class="col-md-1"><?=$form->field($model,'distributorId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"distributors",
                            "onchange"=>"changeDistributor(this,'#games','#servers')",
                            "title"=>"分销商"
                        ]
                    )->label(false)?>
                </div>
                <div class="col-md-1"><?=$form->field($model,'serverId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"servers",
                            "title"=>"选择区服"
                        ]
                    )->label(false)?>
                </div>
                <div class="col-md-1">
                    <?=$form->field($model,'type')->dropDownList(
                        ['服务器向','玩家向'],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"cmdType",
//                            "onchange"=>"changeDistributor(this,'#games','#servers')",
                            "title"=>"命令类型"
                        ]
                    )->label(false)?>
                </div>
                <div class="col-md-1">
                    <?=$form->field($model,'cmdName')->dropDownList(
                        ArrayHelper::map($cmdInfo,'id','shortName'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"cmdName",
                            "onchange"=>"changeCmd(this)",
                            "title"=>"GM命令"
                        ]
                    )->label(false)?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'cmdInfo')->textInput(['maxlength' => true])->label(false) ?>
                </div>

                <div class="col-md-1 form-group">
                    <?= Html::submitButton(Yii::t('app', '执行'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <div>
                <div class="alert alert-info" role="alert">
                    <label class="text-primary">GM命令介绍:</label>
                    <?php
                        for ($i=0;$i<count($cmdInfo);$i++)
                        {
                            echo("<p><label class='text-primary hidden cmd_comment' id='cmd_".$cmdInfo[$i]['id']."'>".$cmdInfo[$i]['comment']."</label></p>");
                        }
                    ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
