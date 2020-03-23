<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabContact */

$this->title = Yii::t('app', 'Create Tab Contact');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-contact-create">

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
