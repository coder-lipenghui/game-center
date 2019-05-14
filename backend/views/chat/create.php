<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabChatControl */

$this->title = Yii::t('app', 'Create Tab Chat Control');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Chat Controls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-chat-control-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
