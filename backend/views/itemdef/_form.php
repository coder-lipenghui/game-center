<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabItemdef */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-itemdef-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'sub_type')->textInput() ?>

    <?= $form->field($model, 'res_id')->textInput() ?>

    <?= $form->field($model, 'icon_id')->textInput() ?>

    <?= $form->field($model, 'script')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shape')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'diejia')->textInput() ?>

    <?= $form->field($model, 'zhanli')->textInput() ?>

    <?= $form->field($model, 'last_time')->textInput() ?>

    <?= $form->field($model, 'giftid')->textInput() ?>

    <?= $form->field($model, 'duramax')->textInput() ?>

    <?= $form->field($model, 'notips')->textInput() ?>

    <?= $form->field($model, 'protect')->textInput() ?>

    <?= $form->field($model, 'ac')->textInput() ?>

    <?= $form->field($model, 'ac2')->textInput() ?>

    <?= $form->field($model, 'mac')->textInput() ?>

    <?= $form->field($model, 'mac2')->textInput() ?>

    <?= $form->field($model, 'dc')->textInput() ?>

    <?= $form->field($model, 'dc2')->textInput() ?>

    <?= $form->field($model, 'mc')->textInput() ?>

    <?= $form->field($model, 'mc2')->textInput() ?>

    <?= $form->field($model, 'sc')->textInput() ?>

    <?= $form->field($model, 'sc2')->textInput() ?>

    <?= $form->field($model, 'luck')->textInput() ?>

    <?= $form->field($model, 'unluck')->textInput() ?>

    <?= $form->field($model, 'hit')->textInput() ?>

    <?= $form->field($model, 'shanbi')->textInput() ?>

    <?= $form->field($model, 'shanbi_mf')->textInput() ?>

    <?= $form->field($model, 'shanbi_zd')->textInput() ?>

    <?= $form->field($model, 'HPhuifu')->textInput() ?>

    <?= $form->field($model, 'MPhuifu')->textInput() ?>

    <?= $form->field($model, 'fabaoparam')->textInput() ?>

    <?= $form->field($model, 'baojijilv')->textInput() ?>

    <?= $form->field($model, 'baojibaifenbi')->textInput() ?>

    <?= $form->field($model, 'baojijiacheng')->textInput() ?>

    <?= $form->field($model, 'needlevel')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'rand_range')->textInput() ?>

    <?= $form->field($model, 'rand_ac')->textInput() ?>

    <?= $form->field($model, 'rand_mac')->textInput() ?>

    <?= $form->field($model, 'rand_dc')->textInput() ?>

    <?= $form->field($model, 'rand_mc')->textInput() ?>

    <?= $form->field($model, 'rand_sc')->textInput() ?>

    <?= $form->field($model, 'add_base_ac')->textInput() ?>

    <?= $form->field($model, 'add_base_mac')->textInput() ?>

    <?= $form->field($model, 'add_base_dc')->textInput() ?>

    <?= $form->field($model, 'add_base_mc')->textInput() ?>

    <?= $form->field($model, 'add_base_sc')->textInput() ?>

    <?= $form->field($model, 'max_hp')->textInput() ?>

    <?= $form->field($model, 'max_mp')->textInput() ?>

    <?= $form->field($model, 'max_hp_pres')->textInput() ?>

    <?= $form->field($model, 'max_mp_pres')->textInput() ?>

    <?= $form->field($model, 'needZLv')->textInput() ?>

    <?= $form->field($model, 'needLv')->textInput() ?>

    <?= $form->field($model, 'needJob')->textInput() ?>

    <?= $form->field($model, 'needGender')->textInput() ?>

    <?= $form->field($model, 'compare')->textInput() ?>

    <?= $form->field($model, 'gongxian')->textInput() ?>

    <?= $form->field($model, 'destroyMsg')->textInput() ?>

    <?= $form->field($model, 'neigong')->textInput() ?>

    <?= $form->field($model, 'background')->textInput() ?>

    <?= $form->field($model, 'huishoujifen')->textInput() ?>

    <?= $form->field($model, 'huishoujinbi')->textInput() ?>

    <?= $form->field($model, 'huishouyuanbao')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
