<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabSuppor */

$this->title = Yii::t('app', 'Create Tab Suppor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Suppors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-suppor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
