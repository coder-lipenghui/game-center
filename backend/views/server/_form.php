<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabServers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-servers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gameId')->textInput() ?>

    <?= $form->field($model, 'distributorId')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'index')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'netPort')->textInput() ?>

    <?= $form->field($model, 'masterPort')->textInput() ?>

    <?= $form->field($model, 'contentPort')->textInput() ?>

    <?= $form->field($model, 'smallDbPort')->textInput() ?>

    <?= $form->field($model, 'bigDbPort')->textInput() ?>

    <?= $form->field($model, 'mergeId')->textInput() ?>

    <?= $form->field($model, 'openDateTime')->widget(DateTimePicker::classname(), [

        'removeButton' => false,
        'options' => [
            'value'=>$model->openDateTime,
            'placeholder' => '开区时间',
        ],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'startView'=>2,     //起始范围（0:分 1:时 2:日 3:月 4:年）
            'maxView'=>4,       //最大选择范围（年）
            'minView'=>0,       //最小选择范围（年）
        ]
    ])?>

    <?= $form->field($model, 'createTime')->widget(DateTimePicker::classname(), [

        'removeButton' => false,
        'options' => [
            'value'=>$model->createTime,
            'placeholder' => '创建时间',
        ],
        'pluginOptions' => [
            'autoclose' => true,
            'todayHighlight' => true,
            'startView'=>2,     //起始范围（0:分 1:时 2:日 3:月 4:年）
            'maxView'=>4,       //最大选择范围（年）
            'minView'=>0,       //最小选择范围（年）
        ]
    ])?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
