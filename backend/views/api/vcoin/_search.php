<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-24
 * Time: 17:21
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
        'options'=>['class'=>'form-inline']
//        'options' => ['data-pjax' => '#myTest' ]
    ]);
?>
<div class="panel-body">
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
        <?=$form->field($searchModel,'isBind')->dropDownList(
            [1=>'元宝',2=>'绑元'],
            [
                "class"=>"selectpicker form-control",
                "data-width"=>"fit",
                "id"=>"servers",
                "onchange"=>"changeServer(this)",
                "title"=>"类型"
            ]
        );?>
        <?=$form->field($searchModel,'type')->dropDownList(
            [1=>'获取',2=>'移除'],
            [
                "class"=>"selectpicker form-control",
                "data-width"=>"fit",
                "id"=>"servers",
                "onchange"=>"changeServer(this)",
                "title"=>"操作"
            ]
        );?>
        <?=$form->field($searchModel,'playerName')->textInput(['placeholder'=>'玩家名称'])?>

        <?=$form->field($searchModel,'src')->textInput(['placeholder'=>'操作方式'])?>

        <?=$form->field($searchModel,'addvc')->textInput(['placeholder'=>'>=元宝数量'])?>

        <?= $form->field($searchModel, 'from')->widget(DateTimePicker::classname(), [
            'options' => [
                'placeholder' => ''
            ],
            'removeButton' => false,
            'pluginOptions' => [
                'format'=>'yyyy-mm-dd H:i:s',
                'autoclose' => true,
                'startView'=>1,
                'maxView'=>3,  //最大选择范围（年）
                'minView'=>1,  //最小选择范围（年）
            ]

        ]);?>

        <?= $form->field($searchModel, 'to')->widget(DateTimePicker::classname(), [
            'options' => [
                'placeholder' => ''
            ],
            'removeButton' => false,
            'pluginOptions' => [
                'format'=>'yyyy-mm-dd H:i:s',
                'autoclose' => true,
                'startView'=>1,
                'maxView'=>3,  //最大选择范围（年）
                'minView'=>1,  //最小选择范围（年）
            ]
        ]);?>

        <?php echo Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
</div>
<?php
ActiveForm::end();
?>
