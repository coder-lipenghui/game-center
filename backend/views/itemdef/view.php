<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabItemdef */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Itemdefs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tab-itemdef-view">

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
            'sub_type',
            'res_id',
            'icon_id',
            'script',
            'name',
            'shape',
            'weight',
            'diejia',
            'zhanli',
            'last_time:datetime',
            'giftid',
            'duramax',
            'notips',
            'protect',
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
            'luck',
            'unluck',
            'hit',
            'shanbi',
            'shanbi_mf',
            'shanbi_zd',
            'HPhuifu',
            'MPhuifu',
            'fabaoparam',
            'baojijilv',
            'baojibaifenbi',
            'baojijiacheng',
            'needlevel',
            'price',
            'rand_range',
            'rand_ac',
            'rand_mac',
            'rand_dc',
            'rand_mc',
            'rand_sc',
            'add_base_ac',
            'add_base_mac',
            'add_base_dc',
            'add_base_mc',
            'add_base_sc',
            'max_hp',
            'max_mp',
            'max_hp_pres',
            'max_mp_pres',
            'needZLv',
            'needLv',
            'needJob',
            'needGender',
            'compare',
            'gongxian',
            'destroyMsg',
            'neigong',
            'background',
            'huishoujifen',
            'huishoujinbi',
            'huishouyuanbao',
            'description',
        ],
    ]) ?>

</div>
