<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdn */

$this->title = Yii::t('app', '指定游戏版本CDN');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'CDN列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cdn-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
