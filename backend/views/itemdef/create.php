<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabItemdefDzy */

$this->title = Yii::t('app', 'Create Tab Itemdef Dzy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Itemdef Dzies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-itemdef-dzy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
