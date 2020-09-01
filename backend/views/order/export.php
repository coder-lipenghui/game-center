<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\datetime\DateTimePicker;
use backend\models\TabDists;
use yii\helpers\ArrayHelper;
$this->title = Yii::t('app', '订单对账');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '订单导出'), 'url' => ['export']];
//$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("@web/js/common.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/order.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJs('
$(function(){
   // getGame("#games");
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
            <div class="col-md-3">
                <?=$form->field($model,'distributorId')->dropDownList(
                ArrayHelper::map(\backend\models\TabDistributor::find()->all(),'id','name'),
                [
                "class"=>"selectpicker form-control col-xs-2",
                "data-width"=>"fit",
                "id"=>"games",
                "onchange"=>"changeGame(this)",
                "title"=>"选择分销商"
                ]
                )->label("分销商");?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
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

                ])->label("时间");?>
            </div>
        </div>
        <hr/>
        <?= Html::submitButton(Yii::t('app', '确定导出'), ['class' => 'btn btn-success']) ?>
        <?php
            ActiveForm::end();
        ?>
    </div>
</div>
