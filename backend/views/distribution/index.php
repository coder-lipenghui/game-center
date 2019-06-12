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

?>
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
                        'attribute'=>'platform',
                        'format'=>'html',
                        'value'=>function($model)
                        {
                            $name="未知";
                            switch ($model->platform)
                            {
                                case 1:
                                    $name="<div>".Html::img("@web/android.png",['width'=>18,'height'=>18])." 安卓</div>";
                                    break;
                                case 2:
                                    $name="<div>".Html::img("@web/ios.png",['width'=>18,'height'=>18])." IOS</div>";
                                    break;
                                case 3:
                                    $name="页游";
                            }
                            return $name;
                        }
                    ],
                    [
                        'attribute'=>'distributorId',
                        'value'=>'distributor.name'
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
                        'attribute'=>'appID',
                        'format'=>'html',
                        'label'=>'分销参数',
                        'value'=>function($model){
                            return Html::a("查看参数",'javascript:;');
                        }
                    ],
                    [
                        'attribute'=>'ratio',
                        'value'=>function($model){
                            return "1:".$model->ratio;
                        }
                    ],
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
//                    'appKey',
//                    'appLoginKey',
//                    'appPaymentKey',
//                    'appPublicKey',
//                    ['attribute'=>'appPublicKey','value'=>function($model){
//                        if (mb_strlen($model->appPublicKey)>10)
//                        {
//                            return mb_substr($model->appPublicKey,0,10)."...";
//                        }else{
//                            return $model->appPublicKey;
//                        }
//                    }],
//                    'parentDT',
//                    'centerLoginKey',
//                    'centerPaymentKey',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
