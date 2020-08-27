<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabBlacklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '黑名单');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-blacklist-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '新增黑名单'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-body">
                <?php Pjax::begin(); ?>
                                <?php  echo $this->render('_search', ['model' => $searchModel,'games'=>$games]); ?>
            
                            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
        'columns' => [
//                ['class' => 'yii\grid\SerialColumn'],

//                            'id',
            ['attribute'=>'gameId','label'=>'游戏'],
            'ip',
            ['attribute'=>'distributionUserId','label'=>'渠道账号'],
            ['attribute'=>'deviceId','label'=>'设备ID'],

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
