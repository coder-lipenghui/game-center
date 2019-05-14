<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabLogLogin */

$this->title = Yii::t('app', 'Create Tab Log Login');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Log Logins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-log-login-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
