<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabItemdefSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-itemdef-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sub_type') ?>

    <?= $form->field($model, 'res_id') ?>

    <?= $form->field($model, 'icon_id') ?>

    <?= $form->field($model, 'script') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'shape') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'diejia') ?>

    <?php // echo $form->field($model, 'zhanli') ?>

    <?php // echo $form->field($model, 'last_time') ?>

    <?php // echo $form->field($model, 'giftid') ?>

    <?php // echo $form->field($model, 'duramax') ?>

    <?php // echo $form->field($model, 'notips') ?>

    <?php // echo $form->field($model, 'protect') ?>

    <?php // echo $form->field($model, 'ac') ?>

    <?php // echo $form->field($model, 'ac2') ?>

    <?php // echo $form->field($model, 'mac') ?>

    <?php // echo $form->field($model, 'mac2') ?>

    <?php // echo $form->field($model, 'dc') ?>

    <?php // echo $form->field($model, 'dc2') ?>

    <?php // echo $form->field($model, 'mc') ?>

    <?php // echo $form->field($model, 'mc2') ?>

    <?php // echo $form->field($model, 'sc') ?>

    <?php // echo $form->field($model, 'sc2') ?>

    <?php // echo $form->field($model, 'luck') ?>

    <?php // echo $form->field($model, 'unluck') ?>

    <?php // echo $form->field($model, 'hit') ?>

    <?php // echo $form->field($model, 'shanbi') ?>

    <?php // echo $form->field($model, 'shanbi_mf') ?>

    <?php // echo $form->field($model, 'shanbi_zd') ?>

    <?php // echo $form->field($model, 'HPhuifu') ?>

    <?php // echo $form->field($model, 'MPhuifu') ?>

    <?php // echo $form->field($model, 'fabaoparam') ?>

    <?php // echo $form->field($model, 'baojijilv') ?>

    <?php // echo $form->field($model, 'baojibaifenbi') ?>

    <?php // echo $form->field($model, 'baojijiacheng') ?>

    <?php // echo $form->field($model, 'needlevel') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'rand_range') ?>

    <?php // echo $form->field($model, 'rand_ac') ?>

    <?php // echo $form->field($model, 'rand_mac') ?>

    <?php // echo $form->field($model, 'rand_dc') ?>

    <?php // echo $form->field($model, 'rand_mc') ?>

    <?php // echo $form->field($model, 'rand_sc') ?>

    <?php // echo $form->field($model, 'add_base_ac') ?>

    <?php // echo $form->field($model, 'add_base_mac') ?>

    <?php // echo $form->field($model, 'add_base_dc') ?>

    <?php // echo $form->field($model, 'add_base_mc') ?>

    <?php // echo $form->field($model, 'add_base_sc') ?>

    <?php // echo $form->field($model, 'max_hp') ?>

    <?php // echo $form->field($model, 'max_mp') ?>

    <?php // echo $form->field($model, 'max_hp_pres') ?>

    <?php // echo $form->field($model, 'max_mp_pres') ?>

    <?php // echo $form->field($model, 'needZLv') ?>

    <?php // echo $form->field($model, 'needLv') ?>

    <?php // echo $form->field($model, 'needJob') ?>

    <?php // echo $form->field($model, 'needGender') ?>

    <?php // echo $form->field($model, 'compare') ?>

    <?php // echo $form->field($model, 'gongxian') ?>

    <?php // echo $form->field($model, 'destroyMsg') ?>

    <?php // echo $form->field($model, 'neigong') ?>

    <?php // echo $form->field($model, 'background') ?>

    <?php // echo $form->field($model, 'huishoujifen') ?>

    <?php // echo $form->field($model, 'huishoujinbi') ?>

    <?php // echo $form->field($model, 'huishouyuanbao') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
