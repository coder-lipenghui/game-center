<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ops\TabOpsMergeLog */

$this->title = Yii::t('app', 'Create Tab Ops Merge Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Ops Merge Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-ops-merge-log-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
