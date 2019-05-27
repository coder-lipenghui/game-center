<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabItemdefDzy */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Itemdef Dzies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tab-itemdef-dzy-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
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
            'wear_pos',
            'sub_type',
            'res_id',
            'icon_id',
            'script',
            'name',
            'color',
            'weight',
            'stackmax',
            'job',
            'gender',
            'needlevel',
            'needzslv',
            'equip_lv',
            'fightpoint',
            'last_time:datetime',
            'gift_id',
            'duramax',
            'flags',
            'pinzhi',
            'protect',
            'drop_luck',
            'ac',
            'ac2',
            'mac',
            'mac2',
            'dc',
            'dc2',
            'mc',
            'mc2',
            'sc',
            'sc2',
            'max_hp',
            'max_mp',
            'max_hp_pres',
            'max_mp_pres',
            'luck',
            'curse',
            'accuracy',
            'dodge',
            'anti_magic',
            'anti_poison',
            'hp_recover',
            'mp_recover',
            'poison_recover',
            'price',
            'mabi_prob',
            'mabi_dura',
            'anti_mabi',
            'frozen_prob',
            'frozen_dura',
            'relive_prob',
            'relive_pres',
            'relive_cd',
            'anti_relive',
            'pveqiege_prob',
            'pveqiege_pres',
            'pvpqiege_prob',
            'pvpqiege_pres',
            'xixue_prob',
            'xixue_pres',
            'baoji_prob',
            'baojipvp_pres',
            'baojipve_pres',
            'baoji_point',
            'baojipvp_point',
            'baojipve_point',
            'anti_baoji',
            'shouhu_pres',
            'attack_pres',
            'defense_pres',
            'addharm_pres',
            'pvpharm_pres',
            'pveharm_pres',
            'subharm_pres',
            'atkspd_pres',
            'hetitime_pres:datetime',
            'heticd_pres',
            'real_harm',
            'drop_pres',
            'equip_comp',
            'contribute',
            'huishou_exp',
            'huishou_jinbi',
            'huishou_vcoin',
            'description',
        ],
    ]) ?>

</div>
