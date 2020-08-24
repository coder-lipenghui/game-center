<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkeyVariety */

$this->title = Yii::t('app', '激活码种类');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Cdkey Varieties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cdkey-variety-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
                'versions'=>$versions
            ]) ?>
        </div>
    </div>
</div>
