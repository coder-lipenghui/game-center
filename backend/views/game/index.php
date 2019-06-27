<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabGamesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '游戏管理');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
$('#paramModal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    
    var number = button.data('number');
    var isbn = button.data('isbn');
    var press = button.data('press');
    var author = button.data('author');
    
    var modal = $(this)
    modal.find('.number').text(number);
    modal.find('.isbn').text(isbn);
    modal.find('.press').text(press);
    modal.find('.author').text(author);
});
");
?>
<div class="modal fade" id="paramModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">参数详情:</h4>
            </div>
            <div class="modal-body">
                <table class="table table-hover">
                    <tr>
                        <td>版号编号:</td>
                        <td class="number"></td>
                    </tr>
                    <tr>
                        <td>ISBN:</td>
                        <td class="isbn"></td>
                    </tr>
                    <tr>
                        <td>出版单位:</td>
                        <td class="press"></td>
                    </tr>
                    <tr>
                        <td>版号所属:</td>
                        <td class="author"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
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
//                    'logo',
//                    'info:ntext',
//                    ['attribute'=>'info','value'=>function($model){
//                        if (mb_strlen($model->info)>10)
//                        {
//                            return mb_substr($model->info,0,10)."...";
//                        }else{
//                            return $model->info;
//                        }
//                    }],
                    'sku',
                    ['attribute'=>'createTime','value'=>function($model){return date('Y-m-d',strtotime($model->createTime));}],
                    [
                        'label'=>'版号信息',
                        'class' => 'common\components\ActionColumn',
                        'template' => '{:view}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $options = [
                                    'data-toggle'=>'modal',
                                    'data-target'=>'#paramModal',
                                    'data-number'=>$model->copyright_number,
                                    'data-isbn'=>$model->copyright_isbn,
                                    'data-press'=>$model->copyright_press,
                                    'data-author'=>$model->copyright_author,
                                ];
                                if ($model->copyright_author)
                                {
                                    return Html::a('点击查看','javascript:;', $options);
                                }else{
                                    return Html::label("-");
                                }

                            },
                        ]
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>


</div>
