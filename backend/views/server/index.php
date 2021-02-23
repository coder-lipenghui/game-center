<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabServersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '区服管理');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
// input 类型
    $('.grid-view table .input-editbale-item').each(function() {
        $(this).dblclick(function() {
            var dataValue = $(this).attr('data-value');
            var inputBox = document.createElement('input');
            inputBox.name = 'item';
            inputBox.className = 'item-edit';
            inputBox.value = dataValue;
            $(this).html(inputBox)
        })
    })
    $('.grid-view table .input-editbale-item').on('keydown', '.item-edit', function(e) {
        if (e.keyCode == 13) {
            var parent = $(this).parent();
            var value = $(this).val();
            var oldValue = parent.attr('data-value');
            var postUrl = parent.attr('data-url');
            var attr = parent.attr('data-attribute');
            postUrl =postUrl;
            $.ajax({
                type: \"POST\",
                url: postUrl,
                dataType: \"json\",
                data: \"_csrf-backend=\" + $('meta[name=csrf-token]') + '&value=' + value + '&old_value=' + oldValue + '&attr=' + attr,
                success: function(msg){
                    if(msg.error == 0) {
                       //window.location.reload();
                    } else {
                        alert(msg.msg);
                    }
                }
            });
            $(this).parent().html(value);
            
        }
    })
");
?>
<div class="tab-servers-index">
    <div class="panel panel-default">
        <div class="panel-body">
                <p>
                    <?= Html::a(Yii::t('app', '新增区服'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>
        </div>
    </div>
    <div class="panel panel-default">

        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?php
                echo $this->render('_search', ['model' => $searchModel]);
                echo("<hr/>");
            ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => ['id',
                    [
                        'attribute'=>'gameId',
                        'value'=>'game.name',
                        'label'=>'游戏名称'
                    ],
                    ['attribute'=>'distributorId','label'=>'分销商','value'=>'distributor.name'],
                    ['attribute'=>'name','label'=>'区服名称'],
                    ['attribute'=>'index','label'=>'区Index'],
//                    ['attribute'=>'status','label'=>'区服状态'],
                    'url:url',
//                    'netPort',
//                    'masterPort',
//                    'contentPort',
//                    'smallDbPort',
//                    'bigDbPort',
                    ['attribute'=>'mergeId','label'=>'合区至',
                        'contentOptions' => function($model) {
                            return ['class' => 'input-editbale-item', 'data-attribute' => 'mergeId', 'data-value' => $model->mergeId, 'data-url' => Url::to('edit-merge-id?id=' . $model->id)];
                        },

//                        'value'=>
//                        function($model){
////                            if (empty($model->mergeId))
////                            {
//                                return Html::activeInput("text",$model,"mergeId");
////                            }else{
////                                return Html::activeInput("text",$model,$model->mergeId);// $model->mergeId;
////                            }
//                        }
                    ],
                    ['attribute'=>'openDateTime','label'=>'开区时间'],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>

    </div>




</div>
