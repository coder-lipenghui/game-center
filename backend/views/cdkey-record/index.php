<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabCdkeyRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '激活码使用记录');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
//            'id',
//                [
//                    'attribute'=>'gameId',
//                    'value'=>'game.name',
//                ],
//                [
//                    'attribute'=>'distributionId',
//                    'value'=>function($model){
//                        return \backend\models\TabDistributor::findOne(['id'=>$model->distribution->distributorId])->name;
//                    },
//                ],
                [
                    'attribute'=>'account',
                    'format'=>'html',
                    'value'=>function($model){
                        return Html::a($model->account,"javascript:;");
                    }
                ],
                [
                    'attribute'=>'serverId',
//                    'value'=>function($model){
//                        return $model->server->name.'('.$model->serverId.')';
//                    }
                ],
                //'roleId',
                'roleName',
                'cdkey',
                'logTime:datetime',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
