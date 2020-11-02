<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\TabServersKuafu */

$this->title = Yii::t('app', 'Create Tab Servers Kuafu');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Servers Kuafus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/kuafu.js',['depends'=>'yii\web\YiiAsset']);
?>
<div class="tab-servers-kuafu-create">
    <div class="panel panel-default">
        <?php
            if ($msg && $msg!="")
            {?>
                <div class="panel-body">
                    <div class="alert alert-success" role="alert" data-dismiss="alert">
                        <p class="text-info">添加成功!</p>
                    </div>
                </div>
        <?php
            }
        ?>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
            <table class="table table-condensed table-bordered">
                <tr>
                    <td width="10%">版本</td>
                    <td width="10%">游戏</td>
                    <td width="10%">名称</td>
                    <td width="5%">index</td>
<!--                    <td>状态</td>-->
                    <td>地址</td>
                    <td width="8%">net</td>
                    <td width="8%">master</td>
                    <td width="8%">content</td>
                    <td width="8%">DB小</td>
                    <td width="8%">DB大</td>
                    <td width="8%">-</td>
                </tr>
                <tr>
                    <td><?= $form->field($model, 'versionId')->dropDownList(array_merge([0=>'选择版本'],$versions),['id'=>'versions',"onchange"=>"getGames()"]) ?></td>
                    <td><?= $form->field($model, 'gameId')->dropDownList([],['id'=>'kuafuGames']) ?></td>
                    <td><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></td>
                    <td><?= $form->field($model, 'index')->textInput() ?></td>
<!--                    <td>--><?//= $form->field($model, 'status')->textInput() ?><!--</td>-->
                    <td><?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?></td>
                    <td><?= $form->field($model, 'netPort')->textInput() ?></td>
                    <td><?= $form->field($model, 'masterPort')->textInput() ?></td>
                    <td><?= $form->field($model, 'contentPort')->textInput() ?></td>
                    <td><?= $form->field($model, 'smallDbPort')->textInput() ?></td>
                    <td><?= $form->field($model, 'bigDbPort')->textInput() ?></td>
                    <td><?= Html::submitButton(Yii::t('app', '新增'), ['class' => 'btn btn-success']) ?></td>
                </tr>
            </table>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
