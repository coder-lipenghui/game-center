<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameScript */

$this->title = Yii::t('app', 'Update Tab Game Script: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '游戏服务器脚本'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tab-game-script-update">

   <div class="panel panel-default">
       <div class="panel-body">
           <?= $this->render('_form', [
           'model' => $model,
           ]) ?>
       </div>
   </div>
</div>
