<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameAssets */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Game Assets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tab-game-assets-view">
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
            'distributionId',
            'versionFile',
            'projectFile',
            'version',
            'executeTime:datetime',
            'enable',
            'svn',
            'comment',
            ],
            ]) ?>
        </div>
    </div>
</div>
