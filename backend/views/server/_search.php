<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TabGames;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\TabServersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-servers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'gameId')->dropDownList(ArrayHelper::map(TabGames::find()->select(['id','name'])->asArray()->all(),'id','name'))->label("游戏") ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'url')->label("域名") ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'name')->label("区服名称") ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'index')->label("区服Index") ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton(Yii::t('app', '重置'), ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
        <?php // echo $form->field($model, 'id')->label(false) ?>
        <?php // echo $form->field($model, 'status') ?>

        <?php // echo $form->field($model, 'netPort') ?>

        <?php // echo $form->field($model, 'masterPort') ?>

        <?php // echo $form->field($model, 'contentPort') ?>

        <?php // echo $form->field($model, 'smallDbPort') ?>

        <?php // echo $form->field($model, 'bigDbPort') ?>

        <?php // echo $form->field($model, 'mergeId') ?>

        <?php // echo $form->field($model, 'openDateTime') ?>

        <?php // echo $form->field($model, 'createTime') ?>
    </div>




    <?php ActiveForm::end(); ?>

</div>
