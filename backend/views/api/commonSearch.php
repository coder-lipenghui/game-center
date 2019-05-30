<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-20
 * Time: 11:55
 *
 *
 * 目前只通过游戏、平台、区服、账号/角色查询接口的公用查询接口
 * 分两部分：
 *       1.RoleInfo model 三个参数：游戏id，平台id，区服id
 *       2.一个二级联动的js
 * 使用方法：
 *       1.在对应页面中 echo $this->render('commonSearch',['searchModel'=>$searchModel]);
 *       2.实现一个自己的
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model backend\models\api\RoleInfo */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('@web/js/common.js');
$this->registerJsFile('@web/js/api/dropdown_menu.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJs('$(function(){
    //getGame("#games",true,null,"../");
})');
?>

<div class="panel-body">
    <?php
    $form=ActiveForm::begin([
        'id'=>'searchForm',
        'action'=>'index',
        'method'=>'post',
        'fieldConfig' => ['template' => '{input}']
    ]);
    ?>
    <div class="row">
        <div class="col-md-1">
            <?=$form->field($searchModel,'gameId')->dropDownList(
                $games,
                [
                    "class"=>"selectpicker form-control col-xs-2",
                    "data-width"=>"fit",
                    "id"=>"games",
                    "onchange"=>"changeGame(this)",
                    "title"=>"选择游戏"
                ]
            );?>
        </div>
        <div class="col-md-1">
            <?=$form->field($searchModel,'distributorId')->dropDownList(
                $distributors,
                [
                    "class"=>"selectpicker form-control col-xs-2",
                    "data-width"=>"fit",
                    "id"=>"platform",
                    "onchange"=>"changePt(this)",
                    "title"=>"选择平台"
                ]
            );?>
        </div>
        <div class="col-md-1">
            <?=$form->field($searchModel,'serverId')->dropDownList(
                $servers,
                [
                    "class"=>"selectpicker form-control col-xs-2",
                    "data-width"=>"fit",
                    "id"=>"servers",
                    "onchange"=>"changeServer(this)",
                    "title"=>"选择区服"
                ]
            );?>
        </div>
        <div class="col-md-2">
            <?=$form->field($searchModel,'chrname')->textInput(['placeholder'=>'角色名称,支持模糊查询'])?>
        </div>
        <div class="col-md-2">
            <?=$form->field($searchModel,'account')->textInput(['placeholder'=>'账号,角色名查询将无效'])?>
        </div>
        <div class="col-md-2">
            <?php //Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-success']) ?>
            <?= Html::button("查询",['class'=>'btn btn-success','onclick'=>'doAjaxSubmit(this)'])?>
        </div>
        <?php
        ActiveForm::end();
        ?>
    </div>
</div>
