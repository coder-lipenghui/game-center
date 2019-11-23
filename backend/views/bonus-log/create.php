<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabBonusLog */

$this->title = Yii::t('app', 'Create Tab Bonus Log');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Bonus Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-bonus-log-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
