<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabDebugServers */

$this->title = Yii::t('app', '新增测试服');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '测试服列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-debug-servers-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
