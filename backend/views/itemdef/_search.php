<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TabItemdefDzySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tab-itemdef-dzy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'wear_pos') ?>

    <?= $form->field($model, 'sub_type') ?>

    <?= $form->field($model, 'res_id') ?>

    <?= $form->field($model, 'icon_id') ?>

    <?php // echo $form->field($model, 'script') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'weight') ?>

    <?php // echo $form->field($model, 'stackmax') ?>

    <?php // echo $form->field($model, 'job') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'needlevel') ?>

    <?php // echo $form->field($model, 'needzslv') ?>

    <?php // echo $form->field($model, 'equip_lv') ?>

    <?php // echo $form->field($model, 'fightpoint') ?>

    <?php // echo $form->field($model, 'last_time') ?>

    <?php // echo $form->field($model, 'gift_id') ?>

    <?php // echo $form->field($model, 'duramax') ?>

    <?php // echo $form->field($model, 'flags') ?>

    <?php // echo $form->field($model, 'pinzhi') ?>

    <?php // echo $form->field($model, 'protect') ?>

    <?php // echo $form->field($model, 'drop_luck') ?>

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

    <?php // echo $form->field($model, 'max_hp') ?>

    <?php // echo $form->field($model, 'max_mp') ?>

    <?php // echo $form->field($model, 'max_hp_pres') ?>

    <?php // echo $form->field($model, 'max_mp_pres') ?>

    <?php // echo $form->field($model, 'luck') ?>

    <?php // echo $form->field($model, 'curse') ?>

    <?php // echo $form->field($model, 'accuracy') ?>

    <?php // echo $form->field($model, 'dodge') ?>

    <?php // echo $form->field($model, 'anti_magic') ?>

    <?php // echo $form->field($model, 'anti_poison') ?>

    <?php // echo $form->field($model, 'hp_recover') ?>

    <?php // echo $form->field($model, 'mp_recover') ?>

    <?php // echo $form->field($model, 'poison_recover') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'mabi_prob') ?>

    <?php // echo $form->field($model, 'mabi_dura') ?>

    <?php // echo $form->field($model, 'anti_mabi') ?>

    <?php // echo $form->field($model, 'frozen_prob') ?>

    <?php // echo $form->field($model, 'frozen_dura') ?>

    <?php // echo $form->field($model, 'relive_prob') ?>

    <?php // echo $form->field($model, 'relive_pres') ?>

    <?php // echo $form->field($model, 'relive_cd') ?>

    <?php // echo $form->field($model, 'anti_relive') ?>

    <?php // echo $form->field($model, 'pveqiege_prob') ?>

    <?php // echo $form->field($model, 'pveqiege_pres') ?>

    <?php // echo $form->field($model, 'pvpqiege_prob') ?>

    <?php // echo $form->field($model, 'pvpqiege_pres') ?>

    <?php // echo $form->field($model, 'xixue_prob') ?>

    <?php // echo $form->field($model, 'xixue_pres') ?>

    <?php // echo $form->field($model, 'baoji_prob') ?>

    <?php // echo $form->field($model, 'baojipvp_pres') ?>

    <?php // echo $form->field($model, 'baojipve_pres') ?>

    <?php // echo $form->field($model, 'baoji_point') ?>

    <?php // echo $form->field($model, 'baojipvp_point') ?>

    <?php // echo $form->field($model, 'baojipve_point') ?>

    <?php // echo $form->field($model, 'anti_baoji') ?>

    <?php // echo $form->field($model, 'shouhu_pres') ?>

    <?php // echo $form->field($model, 'attack_pres') ?>

    <?php // echo $form->field($model, 'defense_pres') ?>

    <?php // echo $form->field($model, 'addharm_pres') ?>

    <?php // echo $form->field($model, 'pvpharm_pres') ?>

    <?php // echo $form->field($model, 'pveharm_pres') ?>

    <?php // echo $form->field($model, 'subharm_pres') ?>

    <?php // echo $form->field($model, 'atkspd_pres') ?>

    <?php // echo $form->field($model, 'hetitime_pres') ?>

    <?php // echo $form->field($model, 'heticd_pres') ?>

    <?php // echo $form->field($model, 'real_harm') ?>

    <?php // echo $form->field($model, 'drop_pres') ?>

    <?php // echo $form->field($model, 'equip_comp') ?>

    <?php // echo $form->field($model, 'contribute') ?>

    <?php // echo $form->field($model, 'huishou_exp') ?>

    <?php // echo $form->field($model, 'huishou_jinbi') ?>

    <?php // echo $form->field($model, 'huishou_vcoin') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
