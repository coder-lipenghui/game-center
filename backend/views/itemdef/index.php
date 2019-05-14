<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabItemdefSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tab Itemdefs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-itemdef-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tab Itemdef'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sub_type',
            'res_id',
            'icon_id',
            'script',
            //'name',
            //'shape',
            //'weight',
            //'diejia',
            //'zhanli',
            //'last_time:datetime',
            //'giftid',
            //'duramax',
            //'notips',
            //'protect',
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
            //'luck',
            //'unluck',
            //'hit',
            //'shanbi',
            //'shanbi_mf',
            //'shanbi_zd',
            //'HPhuifu',
            //'MPhuifu',
            //'fabaoparam',
            //'baojijilv',
            //'baojibaifenbi',
            //'baojijiacheng',
            //'needlevel',
            //'price',
            //'rand_range',
            //'rand_ac',
            //'rand_mac',
            //'rand_dc',
            //'rand_mc',
            //'rand_sc',
            //'add_base_ac',
            //'add_base_mac',
            //'add_base_dc',
            //'add_base_mc',
            //'add_base_sc',
            //'max_hp',
            //'max_mp',
            //'max_hp_pres',
            //'max_mp_pres',
            //'needZLv',
            //'needLv',
            //'needJob',
            //'needGender',
            //'compare',
            //'gongxian',
            //'destroyMsg',
            //'neigong',
            //'background',
            //'huishoujifen',
            //'huishoujinbi',
            //'huishouyuanbao',
            //'description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
