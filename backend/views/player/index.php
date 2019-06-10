<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabPlayersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '账号信息');
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

//                'id',
                [
                    'attribute'=>'gameId',
                    'value'=>'game.name'
                ],
                'distributionId',
                'account',
                'distributionUserId',
                //'distributionUserAccount',
                //'regdeviceId',
                'regtime',
                //'regip',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template'=>'{view}'
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
