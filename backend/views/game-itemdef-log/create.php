<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameItemdefLog */

$this->title = Yii::t('app', '上传物品表');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '物品表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-game-itemdef-log-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'gameId')->dropDownList(ArrayHelper::map(\backend\models\TabGameVersion::find()->select(['id','name'])->asArray()->all(),'id','name')) ?>

            <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model,'file')->fileInput() ?>
            <?= $form->field($model, 'logTime')->widget(DateTimePicker::classname(), [
                'removeButton' => false,
                'options' => [
                    'value'=>date('Y-m-d h:i',time()),
                    'placeholder' => '创建时间'
                ],
                'pluginOptions' => [
                    'format'=>'yyyy-mm-dd h:i:00',
                    'autoclose' => true,
                    'startView'=>2,
                    'maxView'=>3,  //最大选择范围（年）
                    'minView'=>0,  //最小选择范围（年）
                ]
            ]);?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
