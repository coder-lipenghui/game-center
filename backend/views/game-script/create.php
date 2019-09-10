<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameScript */

$this->title = Yii::t('app', '上传脚本');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '游戏服务器脚本'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-game-script-create">
    <?php $form = ActiveForm::begin(["options" => ["enctype" => "multipart/form-data"]]); ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'gameId')->dropDownList($games) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'file')->fileInput() ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', '上 传'), ['class' => 'btn btn-success']) ?>
            </div>


        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
