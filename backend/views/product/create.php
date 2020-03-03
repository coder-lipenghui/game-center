<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabProduct */

$this->title = Yii::t('app', 'Create Tab Product');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-product-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
