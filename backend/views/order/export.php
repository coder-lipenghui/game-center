<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\datetime\DateTimePicker;
use backend\models\TabDists;
use yii\helpers\ArrayHelper;
$this->title = Yii::t('app', '订单导出');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '订单导出'), 'url' => ['export']];
//$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("@web/js/common.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/order.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJs('
$(function(){
    getGame("#games");
})
');
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php
            $form=ActiveForm::begin([
                'action' => ['export'],
                'method' => 'post',
//                'fieldConfig' => ['template' => '{input}'],
                'class'=>'form-inline'
            ]);
        ?>
        <div class="row">
            <div class="col-md-1">
                <?=$form->field($model,'gameid')->dropDownList(
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
            <div class="col-md-2">
                <?= $form->field($model, 'payTime')->widget(DateTimePicker::classname(), [
                    'options' => [
                        'placeholder' => ''
                    ],
                    'value'=>date('Y-m'),
                    'pluginOptions' => [
                    'format'=>'yyyy-mm',
                    'autoclose' => true,
                    'startView'=>3,    //其实范围（0：日  1：天 2：年 3 4）
                    'maxView'=>3,  //最大选择范围（年）
                    'minView'=>3,  //最小选择范围（年）
                    ]

                ]);?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label>选择渠道:</label><?= \yii\bootstrap\Html::checkbox('longxiang',false,['label'=>'龙翔','onchange'=>'onChange(this)','id'=>'longxiang']);?>
                <hr/>
            </div>
            <?= Html::activeCheckboxList($model,'dists',ArrayHelper::map(TabDists::find()->where(['gameid'=>1,'enabled'=>'1','isDebug'=>'0'])->all(),'distributor','name'),[
                'item' => function($index, $label, $name, $checked, $value) {
                    $checked=$checked?"checked":"";
                    $return = '<div class="col-md-2">';
                    $return .= '<input type="checkbox" id="' . $name . $value . '" name="' . $name . '" value="' . $value . '" class="md-checkbox" '.$checked.'>';
                    $return .= '<label for="' . $name . $value . '"><span></span><span class="check"></span><span class="box"></span>' . ucwords($label) . '</label>';
                    $return .= '</div>';
                    return $return;
                }
            ])?>
        </div>
        <hr/>
        <?= Html::submitButton(Yii::t('app', '确定导出'), ['class' => 'btn btn-success']) ?>
        <?php
            ActiveForm::end();
        ?>
    </div>
</div>
