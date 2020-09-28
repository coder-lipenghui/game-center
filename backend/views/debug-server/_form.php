<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\TabDebugServers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-debug-servers-form">

    <?php $form = ActiveForm::begin(); ?>
    <table class="table table-condensed table-bordered">
        <tr class="success">
            <td width="10%">版本</td>
            <td width="5%">Index</td>
            <td width="10%">名称</td>
            <td width="5%">状态</td>
            <td>URL</td>
            <td width="5%">DB-小</td>
            <td width="5%">DB-大</td>
            <td width="7%">Net端口</td>
            <td width="7%">master端口</td>
            <td width="7%">content端口</td>
            <td width="15%">开区时间</td>
        </tr>
        <tr>
            <td><?= $form->field($model, 'versionId')->dropDownList(
                    array_merge([0=>'选择版本'],ArrayHelper::map(\backend\models\TabGameVersion::find()->select(['id','name'])->all(),'id','name'))
                )->label(false) ?></td>
            <td><?= $form->field($model, 'index')->textInput()->label(false) ?></td>
            <td><?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?></td>
            <td><?= $form->field($model, 'status')->dropDownList([1=>'正常',6=>'维护'],['value'=>1])->label(false) ?></td>
            <td><?= $form->field($model, 'url')->textInput(['maxlength' => true])->label(false) ?></td>
            <td><?= $form->field($model, 'smallDbPort')->textInput()->label(false) ?></td>
            <td><?= $form->field($model, 'bigDbPort')->textInput()->label(false) ?></td>
            <td><?= $form->field($model, 'netPort')->textInput()->label(false) ?></td>
            <td><?= $form->field($model, 'masterPort')->textInput()->label(false) ?></td>
            <td><?= $form->field($model, 'contentPort')->textInput()->label(false) ?></td>
            <td><?= $form->field($model, 'openDateTime')->widget(DateTimePicker::classname(), [
                    'options' => [
                        'placeholder' => ''
                    ],
                    'removeButton' => false,
                    'value'=>'2018-10-01',
                    'pluginOptions' => [
                        'format'=>'yyyy-mm-dd hh:ii:ss',
                        'autoclose' => true,
                        'startView'=>2,
                        'maxView'=>7,  //最大选择范围（年）
                        'minView'=>0,  //最小选择范围（年）
                    ]

                ])->label(false); ?></td>
        </tr>
    </table>
    <?= $form->field($model, 'mergeId')->textInput(['class'=>'hidden'])->label(false) ?>
    <?= $form->field($model, 'createTime')->textInput(['value'=>date('Y-m-d H:i:s'),'class'=>'hidden'])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '保存'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
