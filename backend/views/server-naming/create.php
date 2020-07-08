<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabServerNaming */

$this->title = Yii::t('app', 'Create Tab Server Naming');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Server Namings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-server-naming-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            'games'=>$games
            ]) ?>
        </div>
    </div>
</div>
