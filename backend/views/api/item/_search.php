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
        'fieldConfig' => ['template' => '{input}'],
        'options' => ['class' => 'form-inline' ]
    ]);
?>
<div class="panel-body">
    <div class="row">
    <div class="col-xs-1">
        <?=$form->field($searchModel,'gameid')->dropDownList(
            [],
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
    </div>
    <div class="col-xs-1">
        <?=$form->field($searchModel,'serverid')->dropDownList(
            [],
            [
                "class"=>"selectpicker form-control col-xs-2",
                "data-width"=>"fit",
                "id"=>"servers",
                "onchange"=>"changeServer(this)",
                "title"=>"选择区服"
            ]
        );?>
    </div>
    <div class="col-xs-1">
        <?=$form->field($searchModel,'type')->dropDownList(
            [1=>'获取',2=>'移除'],
            [
                "class"=>"selectpicker form-control col-xs-2",
                "data-width"=>"fit",
                "id"=>"servers",
                "onchange"=>"changeServer(this)",
                "title"=>"记录类型"
            ]
        );?>
    </div>
    <div class="col-xs-1">
            <?=$form->field($searchModel,'playerName')->textInput(['placeholder'=>'角色名称'])?>
    </div>
    <div class="col-xs-1">
        <?=$form->field($searchModel,'src')->textInput(['placeholder'=>'获取/移除方式'])?>
    </div>
    <div class="col-xs-1">
        <?=$form->field($searchModel,'identId')->textInput(['placeholder'=>'物品唯一ID,将忽略物品名称'])?>
    </div>
    <div class="col-xs-2">
        <?= $form->field($searchModel, 'from')->widget(DateTimePicker::classname(), [
            'removeButton' => false,
            'options' => [
                'placeholder' => '开始时间'
            ],
            'pluginOptions' => [
                'format'=>'yyyy-mm-dd H:i:s',
                'autoclose' => true,
                'removeButton' => false,
                'startView'=>1,
                'maxView'=>3,  //最大选择范围（年）
                'minView'=>1,  //最小选择范围（年）
            ]

        ]);?>
    </div>
    <div class="col-xs-2">
        <?= $form->field($searchModel, 'to')->widget(DateTimePicker::classname(), [
            'removeButton' => false,
            'options' => [
                'placeholder' => '结束时间'
            ],

            'pluginOptions' => [
                'format'=>'yyyy-mm-dd H:i:s',
                'autoclose' => true,
                'startView'=>1,
                'maxView'=>3,  //最大选择范围（年）
                'minView'=>1,  //最小选择范围（年）
            ]
        ]);?>
    </div>
    <div class="col-xs-1">
        <?php echo Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>
    </div>
</div>
<?php
ActiveForm::end();
?>
