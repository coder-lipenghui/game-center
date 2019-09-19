<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\TabDistributor;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabDistributionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '分销渠道管理');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
$('#paramModal').on('show.bs.modal', function (event) {

    var button = $(event.relatedTarget);
    
    var game = button.data('game');
    var distributor = button.data('distributor');
    
    var appID = button.data('appid');
    var appKey = button.data('appkey');
    var appLoginKey = button.data('apploginkey');
    var appPaymentKey = button.data('apppaymentkey');
    var appPublicKey = button.data('apppublickey');
    
    var modal = $(this)
    modal.find('.game').text(game);
    modal.find('.distributor').text(distributor);
    modal.find('.appID').text(appID);
    modal.find('.appKey').text(appKey);
    modal.find('.appLoginKey').text(appLoginKey);
    modal.find('.appPaymentKey').text(appPaymentKey);
    modal.find('.appPublicKey').text(appPublicKey);
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
                        <td>游戏名称:</td>
                        <td class="game"></td>
                    </tr>
                    <tr>
                        <td>分销商:</td>
                        <td class="distributor"></td>
                    </tr>
                    <tr>
                        <td>应用ID:</td>
                        <td class="appID"></td>
                    </tr>
                    <tr>
                        <td>应用Key:</td>
                        <td class="appKey"></td>
                    </tr>
                    <tr>
                        <td>应用登录Key:</td>
                        <td class="appLoginKey"></td>
                    </tr>
                    <tr>
                        <td>应用支付Key:</td>
                        <td class="appPaymentKey"></td>
                    </tr>
                    <tr>
                        <td>应用私钥Key:</td>
                        <td class="appPrivateKey"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="tab-distribution-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '新增渠道'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute'=>'gameId',
                        'value'=>'game.name'
                    ],
                    [
                        'attribute'=>'distributorId',
                        'format'=>'html',
                        'value'=>function($model){
                            $platform="未知";
                            switch ($model->platform)
                            {
                                case 1:
                                    $platform=Html::img("@web/android.png",['width'=>18,'height'=>18]);
                                    break;
                                case 2:
                                    $platform=Html::img("@web/ios.png",['width'=>18,'height'=>18]);
                                    break;
                                case 3:
                                    $platform="页游";
                            }
                            return $platform."-".$model->distributor->name;
                        }
                        //'distributor.name'
                    ],
                    ['attribute'=>'parentDT','value'=>function($model){
                        if ($model->parentDT)
                        {
                            $distributor=TabDistributor::find()->where(['id'=>$model->parentDT])->one();
                            return $distributor->name;
                        }
                        return "";
                    }],
                    [
                        'attribute'=>'api',
                        'label'=>'SDK',
                        'format'=>'html',
                        'value'=>function($model){
                            return '<span class="label label-primary">'.$model->api.'</span>';
                        }
                    ],
                    [
                        'label'=>'渠道参数',
                        'class' => 'common\components\ActionColumn',
                        'template' => '{:view}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $options = [
                                    'data-toggle'=>'modal',
                                    'data-target'=>'#paramModal',
                                    'data-game'=>$model->game!=null?$model->game->name:"未知游戏",
                                    'data-distributor'=>$model->distributor->name,
                                    'data-appid'=>$model->appID,
                                    'data-appkey'=>$model->appKey,
                                    'data-apploginkey'=>$model->appLoginKey,
                                    'data-apppaymentkey'=>$model->appPaymentKey,
                                    'data-apppublickey'=>$model->appPublicKey
                                ];
                                return Html::a('查看参数','javascript:;', $options);
                            },
                        ]
                    ],
                    [
                        'attribute'=>'ratio',
                        'value'=>function($model){
                            return "1:".$model->ratio;
                        }
                    ],
                    'support',
                    [
                        'attribute'=>'enabled',
                        'format'=>'html',
                        'value'=>function($model)
                        {
                            if ($model->enabled)
                            {
                                return "<span class='label label-success'>已启用</span>";
                            }else{
                                return "<span class='label label-danger'>未启用</span>";
                            }
                        }
                    ],
                    [
                        'attribute'=>'isDebug',
                        'format'=>'html',
                        'value'=>function($model){
                            if ($model->isDebug==1)
                            {
                                return "<span class='label label-warning'>测试中</span>";
                            }else{
                                return "<span class='label label-success'>已完成</span>";
                            }
                        }
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
