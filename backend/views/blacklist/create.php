<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabBlacklist */

$this->title = Yii::t('app', 'Create Tab Blacklist');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Blacklists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-blacklist-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
