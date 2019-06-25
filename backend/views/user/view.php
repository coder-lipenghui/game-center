<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = "账号:".$model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '账号管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                <?= Html::a(Yii::t('app', '修改'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', '删除'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'auth_key',
                    'password_hash',
                    'password_reset_token',
                    'email:email',
                    'status',
                    'created_at',
                    'updated_at',
                    'verification_token',
                ],
            ]) ?>
        </div>
    </div>
</div>
