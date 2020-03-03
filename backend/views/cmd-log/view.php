<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCmdLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Cmd Logs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tab-cmd-log-view">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                        'id',
            'gameId',
            'distributorId',
            'serverId',
            'type',
            'cmdName',
            'cmdInfo',
            'operator',
            'status',
            'result',
            'logTime:datetime',
            ],
            ]) ?>
        </div>
    </div>
</div>
