<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabGameScriptSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '游戏服务器脚本');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-game-script-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '新增脚本'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-body">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
//                ['class' => 'yii\grid\SerialColumn'],
                ['label'=>'游戏名称',
                    'attribute'=>'gameId',
                    'value'=>'version.name',
                ],
                'fileName',
                'fileSize',
                'userId',
                'comment',
                'logTime:datetime',
                ['class' => 'yii\grid\ActionColumn'],
            ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
