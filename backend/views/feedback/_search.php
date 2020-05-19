<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabFeedbackSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-feedback-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="row">
        <div class="col-md-1">
            <?= $form->field($model, 'gameId')->dropDownList($games,
                [
                    "class"=>"selectpicker form-control col-xs-2",
                    "data-width"=>"fit",
                    "title"=>"选择游戏",
                    "id"=>"feedback_game",
                    "onchange"=>"handleChangeGame()"
                ]
            )->label(false) ?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, 'distributorId')->dropDownList([],[
                "class"=>"selectpicker form-control col-xs-2",
                "data-width"=>"fit",
                "title"=>"选择渠道",
                "id"=>"feedback_dist",
//        "onchange"=>"getDist()"
            ])->label(false) ?>
        </div>
        <div class="col-md-1">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
<!--                --><?//= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
