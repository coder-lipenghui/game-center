<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-19
 * Time: 22:00
 */

use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = Yii::t('app', '邮件');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/api/itemSearch.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/common.js');
$this->registerJsFile('@web/js/api/dropdown_menu.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/api/mail.js',['depends'=>'yii\web\YiiAsset']);
/*
 * TODO 因为没有搞通yii2的Pjax+ActiveForm不刷新ActiveForm部分 暂时用了这种特别操蛋的方式
 */
$jsStart="$(function(){";
$jsStart=$jsStart.'getItems("#selectItems",1,"../");';
$jsGetGame='getGame("#games",true,"'.$searchModel->gameid.'","../");';
$jsGetPt="";
$jsGetServer="";
if($searchModel->pid){
    $jsGetPt='//getDistributor("#platform",true,"'.$searchModel->gameid.'","'.$searchModel->pid.'","../");';
}
if ($searchModel->sid)
{
    $jsGetServer='//getServers("#servers",false,"'.$searchModel->gameid.'","'.$searchModel->pid.'","'.$searchModel->sid.'","../");';
}
$jsEnd="})";
$js=$jsStart.$jsEnd;
$this->registerJs($js);
?>
<div class="panel panel-default">
    <?php
    $form=ActiveForm::begin([
        'id'=>'mailForm',
        'action'=>['mail'],
        'method'=>'get',
        'fieldConfig' => ['template' => '{input}'],
//        'options' => ['class' => 'form-inline']
    ]);
    ?>
    <div class="panel-body">
        <div class="row">
            <table class="table table-info">
                <tr>
                    <td>
                        <?=$form->field($searchModel,'gameid')->dropDownList(
                            $games,
                            [
                                "class"=>"selectpicker form-control col-xs-2",
                                "data-width"=>"fit",
                                "id"=>"games",
                                "onchange"=>"changeGame(this)",
                                "title"=>"选择游戏"
                            ]
                        );?>
                    </td>
                    <td>
                        <?=$form->field($searchModel,'pid')->dropDownList(
                            [],
                            [
                                "class"=>"selectpicker form-control col-xs-2",
                                "data-width"=>"fit",
                                "id"=>"platform",
                                "onchange"=>"changePt(this)",
                                "title"=>"选择平台"
                            ]
                        );?>
                    </td>
                    <td>
                        <?=$form->field($searchModel,'type')->dropDownList(
                            [1=>'全平台',2=>'全区',3=>'单人'],
                            [
                                "class"=>"selectpicker form-control col-xs-2",
                                "data-width"=>"fit",
                                "id"=>"type",
                                "onchange"=>"changeServer(this)",
                                "title"=>"发放类型"
                            ]
                        );?>
                    </td>
                    <td>
                        <?=$form->field($searchModel,'sid')->dropDownList(
                            [],
                            [
                                "class"=>"selectpicker form-control col-xs-2",
                                "data-width"=>"fit",
                                "id"=>"servers",
                                "onchange"=>"changeServer(this)",
                                "title"=>"选择区服"
                            ]
                        );?>
                    </td>
                    <td class="col-md-10"></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?=$form->field($searchModel,'playerName')->textInput(['placeholder'=>'玩家名称'])?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <?=$form->field($searchModel,'title')->textInput(['placeholder'=>'标题'])?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <?=$form->field($searchModel,'content')->textarea(['rows'=>5,'placeholder'=>'邮件正文,目前只能85个字(255字节)']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?=$form->field($searchModel,'items')->textInput(['placeholder'=>'附件，建议使用右侧"+"进行物品添加'])?>
            </div>
            <div class="col-md-1">
                <a class="btn btn-default" data-toggle="modal" data-target="#addItemDialog" href="#" >
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end();
    ?>
    <hr/>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-1">
                <button class="btn btn-info" onclick="doMailAjaxSubmit()"><span class="glyphicon glyphicon-send"></span> 发送</button></button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addItemDialog" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">添加物品</h4>
                </div>

                <div class="modal-body" id="kick_playerName">

                    <label>物品名称:</label><select id="selectItems" class="selectpicker" data-live-search="true"></select>
                    <label>数量:</label>
                    <button id="btnSub" onclick="doSub()"><span class="glyphicon glyphicon-minus-sign"></span></button>
                    <input id="itemNum" size="5" value="1"/>
                    <button id="btnAdd" onclick="doAdd()"><span class="glyphicon glyphicon-plus-sign"></span></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="btnOk()">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>