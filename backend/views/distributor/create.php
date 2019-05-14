<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\TabDistributor */

$this->title = Yii::t('app', '新增分销商');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '分销商管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-distributor-create">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'isuse')->textInput() ?>

            <?= $form->field($model, 'create_time')->widget(DateTimePicker::classname(), [

                'options' => [
                    'placeholder' => '创建时间',
                    'value'=>date('Y-m-d H:i:s',time()),
                ],
                'pluginOptions' => [
                    'autoclose' => true,
                    'todayHighlight' => true,
                ]
            ]); ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', '确认添加'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
