<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabPermission */

$this->title = Yii::t('app', 'Create Tab Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-permission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
