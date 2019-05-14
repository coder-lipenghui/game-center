<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabPlayers */

$this->title = Yii::t('app', 'Create Tab Players');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Players'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-players-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
