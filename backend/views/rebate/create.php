<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersRebate */

$this->title = Yii::t('app', 'Create Tab Orders Rebate');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Orders Rebates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-orders-rebate-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
