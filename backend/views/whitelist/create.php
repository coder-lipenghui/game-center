<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabWhitelist */

$this->title = Yii::t('app', 'Create Tab Whitelist');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Whitelists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-whitelist-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
