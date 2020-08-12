<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabSrcSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-src-search">
    <div class="row">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => [
                'data-pjax' => 1
            ],
        ]); ?>
        <div class="col-md-2">
            <?= $form->field($model, 'versionId')->dropDownList($versions)->label(false) ?>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


</div>
