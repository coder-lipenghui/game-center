<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameVersion */

$this->title = Yii::t('app', 'Create Tab Game Version');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Game Versions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-game-version-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
