<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\TabNotice */

$this->title = Yii::t('app', '新增公告');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Notices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("@web/js/common.js");
$this->registerJsFile("@web/js/notice.js");
$this->registerJs('$(function(){
    getGame("#games");
})');
?>

<div class="alert alert-info" role="alert">
    <span class="glyphicon glyphicon-exclamation-sign"></span><font color="black">目前不支持换行操作，有换行的地方请改成换行标签</font>
</div>
<div class="panel panel-default">

    <div class="panel-body">
        <?php
        $form=ActiveForm::begin();
        ?>

        <div class="row">
            <div class="col-md-1">
                <?=
                    $form->field($model,'gameId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"games",
                            "onchange"=>"changeGame(this)",
                            "title"=>"选择游戏"
                        ]
                    )
                ?>
            </div>
            <div class="col-md-1">
                <?= $form->field($model,'distributions')->dropDownList(
                    [],
                    [
                        "class"=>"selectpicker form-control col-xs-2",
                        "data-width"=>"fit",
                        "id"=>"games",
                        "onchange"=>"changeGame(this)",
                        "title"=>"分销渠道"
                    ]
                );?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model,'title')->textInput();?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'starttime')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ]); ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'endtime')->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model,'rank')->textInput();?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php
        ActiveForm::end();
        ?>
    </div>
</div>
