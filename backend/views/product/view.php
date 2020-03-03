<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabProduct */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tab-product-view">
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
            'type',
            'productId',
            'productName',
            'productPrice',
            'productScript',
            'enable',
            ],
            ]) ?>
        </div>
    </div>
</div>
