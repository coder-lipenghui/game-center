<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabGamesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '游戏管理');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-games-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <p>
                <?= Html::a(Yii::t('app', '新增游戏'), ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

        </div>
        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    'name',
                    'logo',
//                    'info:ntext',
                    ['attribute'=>'info','value'=>function($model){
                        if (mb_strlen($model->info)>10)
                        {
                            return mb_substr($model->info,0,10)."...";
                        }else{
                            return $model->info;
                        }
                    }],
                    'sku',
                    ['attribute'=>'createTime','value'=>function($model){return date('Y-m-d',strtotime($model->createTime));}],
                    'copyright_number',
                    'copyright_isbn',
                    'copyright_press',
                    'copyright_author',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>


</div>
