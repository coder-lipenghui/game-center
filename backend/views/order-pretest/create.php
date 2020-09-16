<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersPretest */

$this->title = Yii::t('app', 'Create Tab Orders Pretest');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Orders Pretests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-orders-pretest-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
