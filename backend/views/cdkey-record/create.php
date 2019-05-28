<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkeyRecord */

$this->title = Yii::t('app', 'Create Tab Cdkey Record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Cdkey Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cdkey-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
