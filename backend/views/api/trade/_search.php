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
        <?=$form->field($searchModel,'playerName')->textInput(['placeholder'=>'发起人'])?>

        <?=$form->field($searchModel,'targetName')->textInput(['placeholder'=>'接受人'])?>

        <?=$form->field($searchModel,'mTypeID')->textInput(['placeholder'=>'物品名称'])?>

        <?=$form->field($searchModel,'mIndentID')->textInput(['placeholder'=>'物品唯一ID'])?>

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
        <?php //echo Html::button("查询",['class'=>'btn btn-info','onclick'=>'doAjaxSubmit(this)']) ?>
</div>
<?php
ActiveForm::end();
?>
