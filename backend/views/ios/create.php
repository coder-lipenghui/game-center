<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabIosRelease */

$this->title = Yii::t('app', 'Create Tab Ios Release');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Ios Releases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-ios-release-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
