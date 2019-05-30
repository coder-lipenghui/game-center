<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-19
 * Time: 22:00
 */

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use backend\models\TabActionType;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', '物品交易日志');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/api/itemSearch.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/common.js');
$this->registerJsFile('@web/js/api/dropdown_menu.js',['depends'=>'yii\web\YiiAsset']);

?>
<div class="panel panel-default">

    <?php
        echo $this->render('_search', ['searchModel' => $searchModel,'games'=>$games,'distributors'=>$distributors,'servers'=>$servers]);
    ?>
    <?php
    Pjax::begin();
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'logtime',
            'tradeG',
//            'seedfrom',
            'tradeM',
//            'seedto',
//            'mTypeID',
            ['attribute'=>'mTypeID','value'=>function($model){
                $name=\common\helps\ItemDefHelper::getNameById(1,$model['mTypeID']);
                return $name?$name:$model['mTypeID'];
            }],
//            'mPosition',
//            'mDuraMax',
//            'mDuration',
//            'mItemFlags',
//            'mNumber',
            'mIndentID'
//            'mLuck',
//            'mCreatetime',
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>