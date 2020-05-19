<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabFeedback */

$this->title = Yii::t('app', 'Create Tab Feedback');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Feedbacks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-feedback-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
