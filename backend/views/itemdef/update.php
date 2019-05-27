<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabItemdefDzy */

$this->title = Yii::t('app', 'Update Tab Itemdef Dzy: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Itemdef Dzies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tab-itemdef-dzy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
