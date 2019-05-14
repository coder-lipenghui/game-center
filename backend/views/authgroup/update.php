<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabAuthGroupAccess */

$this->title = Yii::t('app', 'Update Tab Auth Group Access: {name}', [
    'name' => $model->uid,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Auth Group Accesses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uid, 'url' => ['view', 'uid' => $model->uid, 'group_id' => $model->group_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tab-auth-group-access-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
