<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabCmdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tab Cmds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cmd-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', 'Create Tab Cmd'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-body">
                <?php Pjax::begin(); ?>
                                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            
                            <?= GridView::widget([
                                    'options'=>['class'=>'table table-striped table-condensed'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                            #'id',
            ['attribute'=>'type','value'=>function($model){
                if ($model->type==1)
                {
                    return '服务器类型';
                }
                if ($model->type==2)
                {
                    return '玩家类型';
                }
            }],
            'name',
            'comment',

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
