<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabSrc */

$this->title = Yii::t('app', '上传变量表');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Srcs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-src-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?php
                if ($msg)
                {
                    echo('<div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success!</strong> 上传成功.
                        </div>');
                }
            ?>
            
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'versionId')->dropDownList($versions)->label("游戏版本") ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model,'file')->fileInput()->label("变量lua文件") ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', '上传'), ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
