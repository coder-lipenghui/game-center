<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/cdk.js',['depends'=>'yii\web\YiiAsset']);
/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkeyVariety */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-cdkey-variety-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'gameId')->dropDownList($versions,['onchange'=>'handleGameVersionChange()'])->label("选择版本") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'type')->dropDownList([1=>'普通',2=>'通用'])->label("激活码类型") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('激活码名称') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'once')->dropDownList([0=>'否',1=>'是'])->label("只能使用一次") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'deliverType')->dropDownList([1=>'脚本',2=>'邮件'])->label("发放方式") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'items')->textInput(['maxlength' => true,'placeholder'=>'激活码对应的物品'])->label(false) ?>
        </div>
        <div class="col-md-6">
            <div class="col-md-1">
                <a class="btn btn-default" data-toggle="modal" data-target="#addItemDialog" href="#"  id="btnAdd">
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '确 定'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div class="modal fade" id="addItemDialog" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">添加物品</h4>
                </div>

                <div class="modal-body" id="kick_playerName">
                    <label>物品名称:</label>
                    <?php
                    echo Html::dropDownList(
                        "selectItems",
                        null,
                        [],
                        [
                            'id'=>'selectItems',
                            'class'=>'selectpicker',
                            'data-live-search'=>'true'
                        ]
                    );
                    ?>
                    <label>数量:</label>
                    <button id="btnSub" onclick="doSub()"><span class="glyphicon glyphicon-minus-sign"></span></button>
                    <input id="itemNum" size="5" value="1"/>
                    <button id="btnAdd" onclick="doAdd()"><span class="glyphicon glyphicon-plus-sign"></span></button>
                    <label>绑定:</label>
                    <input type="checkbox" id="ckBind" checked="checked"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="addOneItem()">确认</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
