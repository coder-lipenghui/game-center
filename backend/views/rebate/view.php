<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrdersRebate */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Orders Rebates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tab-orders-rebate-view">
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
                <?= Html::a(Yii::t('app', '补发'), ['reissue', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
    </div>
    <?php
        if (!empty($model->msg))
        {
            $class=$model->msg=="补发成功"?"alert-success":"alert-danger";
            echo("<div class='alert $class' role='alert'>$model->msg</div>");
        }
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                        'id',
            'gameId',
            'distributorId',
            'distributionId',
            'orderId',
            'distributionOrderId',
            'distributionUserId',
            'gameRoleId',
            'gameRoleName',
            'gameServerId',
            'gameServername',
            'gameAccount',
            'productId',
            'productName',
            'payAmount',
            'payStatus',
            'payMode',
            'payTime:datetime',
            'createTime:datetime',
            'delivered',
            ],
            ]) ?>
        </div>
    </div>
</div>
