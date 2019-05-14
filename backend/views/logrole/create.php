<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabLogRole */

$this->title = Yii::t('app', 'Create Tab Log Role');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Log Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-log-role-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
