<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabFeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '问题反馈');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/feedback.js',['depends'=>'yii\web\YiiAsset']);
?>
<div class="tab-feedback-index">
    <div class="panel panel-body">
        <?php  echo $this->render('_search', ['model' => $searchModel,'games'=>$games]); ?>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-body">
            <?php Pjax::begin(); ?>
                <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                'serverId',
                'roleName',
                'title',
                'content',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'buttons' => [
                        'view' => function ($url, $model, $key){
                            return "<a href='/feedback/view/?id=$model->id&gameId=$model->gameId&distributorId=$model->distributorId' title='查看' aria-label='查看' data-pjax='0'><span class='glyphicon glyphicon-eye-open'></span></a>";
                        },
                        'update' => function ($url, $model, $key){
                            return "<a href='/feedback/update/?id=$model->id&gameId=$model->gameId&distributorId=$model->distributorId' title='更新' aria-label='更新' data-pjax='0'><span class='glyphicon glyphicon-pencil'></span></a>";
                        },
                        'delete' => function ($url, $model, $key){
                            return "<a href=\"/feedback/delete?id=$model->id&gameId=$model->gameId&distributorId=$model->distributorId\" title=\"删除\" aria-label=\"删除\" data-pjax=\"0\" data-confirm=\"您确定要删除此项吗？\" data-method=\"post\"><span class=\"glyphicon glyphicon-trash\"></span></a>";
                        },
                    ]
                ],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
