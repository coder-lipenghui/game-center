<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabActionTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '日志记录方式');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <p>
            <?= Html::a(Yii::t('app', '更新SRC'), ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', '新增SRC'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
</div>
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
//                'actionId',
                [
                    'attribute'=>'actionId',
                    'format'=>'html',
                    'value'=>function($model)
                    {
                        if ($model->actionType==1)
                        {
                            return $model->actionId."  <small><span class='label label-info'>获取</span></small>";
                        }else{
                            return $model->actionId."  <span class='label label-warning'>移除</span>";
                        }
                    }
                ],
                'actionLua',
                'actionName',
//                'actionDesp',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
