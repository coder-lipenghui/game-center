<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdn */

$this->title = Yii::t('app', 'CDN分配');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Cdns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cdn-create">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
