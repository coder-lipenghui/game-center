<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\TabDistributor;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabDistributionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '分销管理');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="tab-distribution-index">
    <div class="panel panel-default">
        <div class="panel-body">
                <p>
                    <?= Html::a(Yii::t('app', '新增分销'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    [
                        'attribute'=>'gameId',
                        'value'=>'game.name'
                    ],
                    [
                        'attribute'=>'platform',
                        'value'=>function($model)
                        {
                            $name="未知";
                            switch ($model->platform)
                            {
                                case 1:
                                    $name="安卓";
                                    break;
                                case 2:
                                    $name="IOS";
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
//                    'parentDT',
                    ['attribute'=>'parentDT','value'=>function($model){
//                        exit("model:".$model->parentDT);
                        if ($model->parentDT)
                        {
                            $distributor=TabDistributor::find()->where(['id'=>$model->parentDT])->one();
//                            exit($distributor->createCommand()->getRawSql());
                            return $distributor->name;
                        }
                        return "-";
                    }],
//                    'centerLoginKey',
//                    'centerPaymentKey',
                    'appID',
                    'appKey',
                    'appLoginKey',
                    'appPaymentKey',
//                    'appPublicKey',
                    ['attribute'=>'appPublicKey','value'=>function($model){
                        if (mb_strlen($model->appPublicKey)>10)
                        {
                            return mb_substr($model->appPublicKey,0,10)."...";
                        }else{
                            return $model->appPublicKey;
                        }
                    }],
                    'enabled',
                    //'isDebug',
//                    'api',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
