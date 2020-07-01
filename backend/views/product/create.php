<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabProduct */

$this->title = Yii::t('app', '新增计费点');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-product-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            'games'=>$games
            ]) ?>
        </div>
    </div>
</div>
