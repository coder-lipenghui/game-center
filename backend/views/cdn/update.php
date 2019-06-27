<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdn */

$this->title = Yii::t('app', 'Update Tab Cdn: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Cdns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tab-cdn-update">

   <div class="panel panel-default">
       <div class="panel-body">
           <?= $this->render('_form', [
           'model' => $model,
           ]) ?>
       </div>
   </div>
</div>
