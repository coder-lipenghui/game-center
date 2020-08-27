<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabBlacklistSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
        'data-pjax' => 1
    ],
]); ?>
<div class="panel panel-body">
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'gameId')->dropDownList($games)->label("游戏") ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ip')->label("登录IP") ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'distributionUserId')->label("渠道账号") ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'deviceId')->label("设备ID") ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>