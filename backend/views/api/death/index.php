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
use backend\models\TabActionLog;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('app', '玩家死亡日志');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/api/itemSearch.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/common.js');
$this->registerJsFile('@web/js/api/dropdown_menu.js',['depends'=>'yii\web\YiiAsset']);
//$this->registerJsFile('@web/js/api/deathSearch.js',['depends'=>'yii\web\YiiAsset']);

$jsStart="$(function(){";
$jsGetGame='getGame("#games",true,"'.$searchModel->gameid.'","../");';
$jsGetPt="";
$jsGetServer="";
if($searchModel->pid){
    $jsGetPt='getDistributor("#platform",true,"'.$searchModel->gameid.'","'.$searchModel->pid.'","../");';
}
if ($searchModel->serverid)
{
    $jsGetServer='getServers("#servers",false,"'.$searchModel->gameid.'","'.$searchModel->pid.'","'.$searchModel->serverid.'","../");';
}
$jsEnd="})";
$js=$jsStart.$jsGetGame.$jsGetPt.$jsGetServer.$jsEnd;
//$this->registerJs($js);
?>
<div class="panel panel-default">

    <?php
        echo $this->render('_search', ['searchModel' => $searchModel,'games'=>$games]);
    ?>
    <?php
    Pjax::begin();
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'chrname',
//            'mapid',
            ['attribute'=>'mapid','value'=>function($model){return $model['mapid']."(".$model['x'].",".$model['y'].")";}],
//            'x',
//            'y',
            'killname',
            'logtime'
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>