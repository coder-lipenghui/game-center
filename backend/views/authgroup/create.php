<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabAuthGroupAccess */

$this->title = Yii::t('app', 'Create Tab Auth Group Access');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Auth Group Accesses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-auth-group-access-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
