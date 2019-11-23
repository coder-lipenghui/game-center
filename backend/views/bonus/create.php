<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabBonus */

$this->title = Yii::t('app', 'Create Tab Bonus');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Bonuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-bonus-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
