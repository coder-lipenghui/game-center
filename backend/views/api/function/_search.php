<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-20
 * Time: 11:55
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model backend\models\api\RoleInfo */
/* @var $form yii\widgets\ActiveForm */

?>
<?php
    $form=ActiveForm::begin([
        'id'=>'functionSearchForm',
        'action'=>['index'],
        'method'=>'get',
        'fieldConfig' => ['template' => '{input}'],
        'options' => ['class' => 'form-inline' ]
    ]);
?>
<div class="panel-body">
    <div class="row">
    <div class="col-xs-1">
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
    <div class="col-xs-1">
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
    <div class="col-xs-1">
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
    </div>
</div>
<?php
ActiveForm::end();
?>
