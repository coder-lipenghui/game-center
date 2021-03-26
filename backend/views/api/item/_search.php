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
        'id'=>'itemSearchForm',
        'action'=>['index'],
        'method'=>'get',
//        'fieldConfig' => ['template' => '{input}'],
        'options' => ['class' => 'form-inline' ]
    ]);
?>
<div class="panel-body">
    <div class="row">
        <div class="col-md-2">
            <?=$form->field($searchModel,'gameId')->dropDownList(
                $games,
                [
                    "class"=>"selectpicker form-control col-md-2",
                    "data-width"=>"fit",
                    "id"=>"games",
                    "onchange"=>"changeGame(this)",
                    "title"=>"选择游戏"
                ]
            );?>
        </div>
        <div class="col-md-2">
            <?=$form->field($searchModel,'distributorId')->dropDownList(
                $distributors,
                [
                    "class"=>"selectpicker form-control col-md-2",
                    "data-width"=>"fit",
                    "id"=>"platform",
                    "onchange"=>"changePt(this)",
                    "title"=>"选择平台"
                ]
            );?>
        </div>
        <div class="col-md-2">
            <?=$form->field($searchModel,'serverId')->dropDownList(
                $servers,
                [
                    "class"=>"selectpicker form-control col-md-2",
                    "data-width"=>"fit",
                    "id"=>"servers",
                    "onchange"=>"changeServer(this)",
                    "title"=>"选择区服"
                ]
            );?>
        </div>
        <div class="col-md-3">
            <?=$form->field($searchModel,'type')->dropDownList(
                [1=>'获取',2=>'移除'],
                [
                    "class"=>"selectpicker form-control col-md-2",
                    "data-width"=>"fit",
                    "id"=>"recordType",
                    "onchange"=>"changeRecordType(this)",
                    "title"=>"记录类型"
                ]
            );?>
        </div>
        <div class="col-md-3">
            <?=$form->field($searchModel,'src')->dropDownList(
                [],
                [
                    "class"=>"selectpicker form-control col-md-2",
                    "data-width"=>"fit",
                    "data-live-search"=>"true",
                    "id"=>"src",
                    "title"=>"方式"
                ]
            );?>
        </div>
    </div>
    <div class="row row-margin-top">
        <div class="col-md-2">
                <?=$form->field($searchModel,'playerName')->textInput(['placeholder'=>'角色名称'])?>
        </div>
        <div class="col-md-2">
            <?=$form->field($searchModel,'itemName')->textInput(['placeholder'=>'物品名称'])?>
        </div>
        <div class="col-md-3">
            <?=$form->field($searchModel,'identId')->textInput(['placeholder'=>'物品唯一ID,将忽略物品名称'])?>
        </div>
    </div>
    <div class="row row-margin-top">
        <div class="col-md-2">
            <?= $form->field($searchModel, 'from')->widget(DateTimePicker::classname(), [
                'removeButton' => false,
                'options' => [
                    'placeholder' => '开始时间'
                ],
                'pluginOptions' => [
                    'format'=>'yyyy-mm-dd h:i:s',
                    'autoclose' => true,
                    'removeButton' => false,
    //                'startView'=>1,
    //                'maxView'=>4,  //最大选择范围（年）
    //                'minView'=>1,  //最小选择范围（年）
                ]

            ]);?>
        </div>
        <div class="col-md-2">
            <?= $form->field($searchModel, 'to')->widget(DateTimePicker::classname(), [
                'removeButton' => false,
                'options' => [
                    'placeholder' => '结束时间'
                ],

                'pluginOptions' => [
                    'format'=>'yyyy-mm-dd h:i:s',
                    'autoclose' => true,
    //                'startView'=>1,
    //                'maxView'=>4,  //最大选择范围（年）
    //                'minView'=>1,  //最小选择范围（年）
                ]
            ]);?>
        </div>
    </div>
    <div class="row row-margin-top">
        <div class="col-md-12">
            <?php echo Html::submitButton(Yii::t('app', '查 询'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php
ActiveForm::end();
?>
