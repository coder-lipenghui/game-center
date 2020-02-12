<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ops\TabUpdateScriptLog */

$this->title = Yii::t('app', 'Create Tab Update Script Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Update Script Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-update-script-log-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
