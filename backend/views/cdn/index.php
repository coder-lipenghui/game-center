<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabCdnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '热更、资源下载地址');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cdn-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '新增版本CDN'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-body">
                <?php Pjax::begin(); ?>
                                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            
                            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
        'columns' => [
//                ['class' => 'yii\grid\SerialColumn'],

//                            'id',
            ['attribute'=>'versionId','label'=>'版本','value'=>'gameVersion.name'],
            ['attribute'=>'gameId','label'=>'游戏','value'=>'game.name'],
            ['attribute'=>'updateUrl','label'=>'热更地址'],
            ['attribute'=>'assetsUrl','label'=>'资源地址'],
            ['attribute'=>'platform','label'=>'服务商'],
            //'secretId',
            //'secretKey',
            //'comment',

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
