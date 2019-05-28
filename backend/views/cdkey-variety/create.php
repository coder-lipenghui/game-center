<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkeyVariety */

$this->title = Yii::t('app', '新增激活码分类');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '激活码分类管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cdkey-variety-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
