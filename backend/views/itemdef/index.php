<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabItemdefDzySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '单职业物品表');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-itemdef-dzy-index">
    <div class="panel panel-default">
        <div class="panel-body">
    <p>
        <?php Html::a(Yii::t('app', '新增'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
//            'wear_pos',
//            'sub_type',
//            'res_id',
//            'icon_id',
            'script',
            'name',
            'color',
            //'weight',
            //'stackmax',
            'job',
            'gender',
            //'needlevel',
            //'needzslv',
            //'equip_lv',
            //'fightpoint',
            //'last_time:datetime',
            //'gift_id',
            //'duramax',
            //'flags',
            //'pinzhi',
            //'protect',
            //'drop_luck',
            //'ac',
            //'ac2',
            //'mac',
            //'mac2',
            //'dc',
            //'dc2',
            //'mc',
            //'mc2',
            //'sc',
            //'sc2',
            //'max_hp',
            //'max_mp',
            //'max_hp_pres',
            //'max_mp_pres',
            //'luck',
            //'curse',
            //'accuracy',
            //'dodge',
            //'anti_magic',
            //'anti_poison',
            //'hp_recover',
            //'mp_recover',
            //'poison_recover',
            //'price',
            //'mabi_prob',
            //'mabi_dura',
            //'anti_mabi',
            //'frozen_prob',
            //'frozen_dura',
            //'relive_prob',
            //'relive_pres',
            //'relive_cd',
            //'anti_relive',
            //'pveqiege_prob',
            //'pveqiege_pres',
            //'pvpqiege_prob',
            //'pvpqiege_pres',
            //'xixue_prob',
            //'xixue_pres',
            //'baoji_prob',
            //'baojipvp_pres',
            //'baojipve_pres',
            //'baoji_point',
            //'baojipvp_point',
            //'baojipve_point',
            //'anti_baoji',
            //'shouhu_pres',
            //'attack_pres',
            //'defense_pres',
            //'addharm_pres',
            //'pvpharm_pres',
            //'pveharm_pres',
            //'subharm_pres',
            //'atkspd_pres',
            //'hetitime_pres:datetime',
            //'heticd_pres',
            //'real_harm',
            //'drop_pres',
            //'equip_comp',
            //'contribute',
            //'huishou_exp',
            //'huishou_jinbi',
            //'huishou_vcoin',
            'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
        </div>
    </div>
</div>
