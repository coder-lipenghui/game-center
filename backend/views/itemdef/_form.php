<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabItemdefDzy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-itemdef-dzy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'wear_pos')->textInput() ?>

    <?= $form->field($model, 'sub_type')->textInput() ?>

    <?= $form->field($model, 'res_id')->textInput() ?>

    <?= $form->field($model, 'icon_id')->textInput() ?>

    <?= $form->field($model, 'script')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'stackmax')->textInput() ?>

    <?= $form->field($model, 'job')->textInput() ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'needlevel')->textInput() ?>

    <?= $form->field($model, 'needzslv')->textInput() ?>

    <?= $form->field($model, 'equip_lv')->textInput() ?>

    <?= $form->field($model, 'fightpoint')->textInput() ?>

    <?= $form->field($model, 'last_time')->textInput() ?>

    <?= $form->field($model, 'gift_id')->textInput() ?>

    <?= $form->field($model, 'duramax')->textInput() ?>

    <?= $form->field($model, 'flags')->textInput() ?>

    <?= $form->field($model, 'pinzhi')->textInput() ?>

    <?= $form->field($model, 'protect')->textInput() ?>

    <?= $form->field($model, 'drop_luck')->textInput() ?>

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

    <?= $form->field($model, 'max_hp')->textInput() ?>

    <?= $form->field($model, 'max_mp')->textInput() ?>

    <?= $form->field($model, 'max_hp_pres')->textInput() ?>

    <?= $form->field($model, 'max_mp_pres')->textInput() ?>

    <?= $form->field($model, 'luck')->textInput() ?>

    <?= $form->field($model, 'curse')->textInput() ?>

    <?= $form->field($model, 'accuracy')->textInput() ?>

    <?= $form->field($model, 'dodge')->textInput() ?>

    <?= $form->field($model, 'anti_magic')->textInput() ?>

    <?= $form->field($model, 'anti_poison')->textInput() ?>

    <?= $form->field($model, 'hp_recover')->textInput() ?>

    <?= $form->field($model, 'mp_recover')->textInput() ?>

    <?= $form->field($model, 'poison_recover')->textInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'mabi_prob')->textInput() ?>

    <?= $form->field($model, 'mabi_dura')->textInput() ?>

    <?= $form->field($model, 'anti_mabi')->textInput() ?>

    <?= $form->field($model, 'frozen_prob')->textInput() ?>

    <?= $form->field($model, 'frozen_dura')->textInput() ?>

    <?= $form->field($model, 'relive_prob')->textInput() ?>

    <?= $form->field($model, 'relive_pres')->textInput() ?>

    <?= $form->field($model, 'relive_cd')->textInput() ?>

    <?= $form->field($model, 'anti_relive')->textInput() ?>

    <?= $form->field($model, 'pveqiege_prob')->textInput() ?>

    <?= $form->field($model, 'pveqiege_pres')->textInput() ?>

    <?= $form->field($model, 'pvpqiege_prob')->textInput() ?>

    <?= $form->field($model, 'pvpqiege_pres')->textInput() ?>

    <?= $form->field($model, 'xixue_prob')->textInput() ?>

    <?= $form->field($model, 'xixue_pres')->textInput() ?>

    <?= $form->field($model, 'baoji_prob')->textInput() ?>

    <?= $form->field($model, 'baojipvp_pres')->textInput() ?>

    <?= $form->field($model, 'baojipve_pres')->textInput() ?>

    <?= $form->field($model, 'baoji_point')->textInput() ?>

    <?= $form->field($model, 'baojipvp_point')->textInput() ?>

    <?= $form->field($model, 'baojipve_point')->textInput() ?>

    <?= $form->field($model, 'anti_baoji')->textInput() ?>

    <?= $form->field($model, 'shouhu_pres')->textInput() ?>

    <?= $form->field($model, 'attack_pres')->textInput() ?>

    <?= $form->field($model, 'defense_pres')->textInput() ?>

    <?= $form->field($model, 'addharm_pres')->textInput() ?>

    <?= $form->field($model, 'pvpharm_pres')->textInput() ?>

    <?= $form->field($model, 'pveharm_pres')->textInput() ?>

    <?= $form->field($model, 'subharm_pres')->textInput() ?>

    <?= $form->field($model, 'atkspd_pres')->textInput() ?>

    <?= $form->field($model, 'hetitime_pres')->textInput() ?>

    <?= $form->field($model, 'heticd_pres')->textInput() ?>

    <?= $form->field($model, 'real_harm')->textInput() ?>

    <?= $form->field($model, 'drop_pres')->textInput() ?>

    <?= $form->field($model, 'equip_comp')->textInput() ?>

    <?= $form->field($model, 'contribute')->textInput() ?>

    <?= $form->field($model, 'huishou_exp')->textInput() ?>

    <?= $form->field($model, 'huishou_jinbi')->textInput() ?>

    <?= $form->field($model, 'huishou_vcoin')->textInput() ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
