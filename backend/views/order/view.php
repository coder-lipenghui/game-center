<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabOrders */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tab-orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
<?= Html::a(Yii::t('app', '补发'), ['reissue', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
<?//= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                'method' => 'post',
//            ],
//        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'gameId',
            'distributionId',
            'orderId',
            'distributionOrderId',
            'distributionUserId',
            'gameRoleId',
            'gameRoleName',
            'gameServerId',
            'gameServername',
            'gameAccount',
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
