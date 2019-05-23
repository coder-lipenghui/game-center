<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-24
 * Time: 10:55
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
    ]);
?>
<div class="panel-body">
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
        <?=$form->field($searchModel,'playerName')->textInput(['placeholder'=>'发起人'])?>

        <?=$form->field($searchModel,'targetName')->textInput(['placeholder'=>'接受人'])?>

        <?=$form->field($searchModel,'vcoin')->textInput(['placeholder'=>'>=元宝数量'])?>

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
