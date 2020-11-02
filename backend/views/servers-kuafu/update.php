<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabServersKuafu */

$this->title = Yii::t('app', 'Update Tab Servers Kuafu: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Servers Kuafus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tab-servers-kuafu-update">

   <div class="panel panel-default">
       <div class="panel-body">
           <?= $this->render('_form', [
                'model' => $model,
                'versions'=>$versions
           ]) ?>
       </div>
   </div>
</div>
