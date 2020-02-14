<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCmd */

$this->title = Yii::t('app', 'Create Tab Cmd');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Cmds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cmd-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
