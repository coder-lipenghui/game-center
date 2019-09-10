<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameAssets */

$this->title = Yii::t('app', 'Create Tab Game Assets');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Game Assets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-game-assets-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
