<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabItemdef */

$this->title = Yii::t('app', 'Create Tab Itemdef');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Itemdefs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-itemdef-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
