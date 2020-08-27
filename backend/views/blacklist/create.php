<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabBlacklist */

$this->title = Yii::t('app', '新增黑名单');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '黑名单'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-blacklist-create">

    <div class="panel panel-default">
        <div class="panel-heading">
            账号、IP、设备ID三选一填写
        </div>
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
                'games'=>$games,
            ]) ?>
        </div>
    </div>
</div>
