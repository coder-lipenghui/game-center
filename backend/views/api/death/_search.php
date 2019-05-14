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
//        'options' => ['data-pjax' => '#myTest' ]
    ]);
?>
<div class="panel-body">
    <div class="row">
        <div class="col-sm-1">
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
        <div class="col-sm-1">
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
        <div class="col-sm-1">
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
        <div class="col-sm-2">
            <?=$form->field($searchModel,'playerName')->textInput(['placeholder'=>'角色名称'])?>
        </div>

        <div class="col-md-2">
            <?= $form->field($searchModel, 'from')->widget(DateTimePicker::classname(), [
                'options' => [
                    'placeholder' => ''
                ],
                'removeButton' => false,
                'value'=>'2018-10-01',
                'pluginOptions' => [
                    'format'=>'yyyy-mm-dd H:i:s',
                    'autoclose' => true,
                    'startView'=>1,
                    'maxView'=>3,  //最大选择范围（年）
                    'minView'=>1,  //最小选择范围（年）
                ]

            ]);?>
        </div>
        <div class="col-md-2">
            <?= $form->field($searchModel, 'to')->widget(DateTimePicker::classname(), [
                'options' => [
                    'placeholder' => ''
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
        <div class="col-md-2">
            <?php echo Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
            <?php //echo Html::button("查询",['class'=>'btn btn-info','onclick'=>'doAjaxSubmit(this)']) ?>
        </div>
    </div>
</div>
<?php
ActiveForm::end();
?>
