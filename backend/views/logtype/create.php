<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabActionType */

$this->title = Yii::t('app', 'Create Tab Action Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Action Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-action-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
