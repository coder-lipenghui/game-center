<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Cdns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tab-cdn-view">
    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
                ],
                ]) ?>
            </p>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                        'id',
            'gameId',
            'updateUrl',
            'assetsUrl',
            'platform',
            'secretId',
            'secretKey',
            'comment',
            ],
            ]) ?>
        </div>
    </div>
</div>
