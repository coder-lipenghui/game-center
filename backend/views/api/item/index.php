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

$this->title = Yii::t('app', '物品日志');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/api/itemSearch.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/common.js');
$this->registerJsFile('@web/js/api/dropdown_menu.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/api/itemSearch.js',['depends'=>'yii\web\YiiAsset']);
/*
 * TODO 因为没有搞通yii2的Pjax+ActiveForm不刷新ActiveForm部分 暂时用了这种特别操蛋的方式
 */
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
$this->registerJs($js);
?>
<div class="panel panel-default">

    <?php
        echo $this->render('_search', ['searchModel' => $searchModel]);
    ?>
    <?php
    Pjax::begin(['id'=>'myTest']);
    ?>
            <?= GridView::widget([
                'id'=>'itemLog',
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'playername',
//                    ['attribute'=>'playername','label'=>'角色名称'],
                    'logtime',
//                    ['attribute'=>'logtime','label'=>'获取时间'],
//                    'src',
                    [
                        'attribute'=>'src',
                        'value'=>function($model){
                            $src=$model['src'];
                            $name="";
                            try {
                                $name = \common\helps\RecordHelper::getNameById(1,$model['src']);
                            }catch(Exception $e){

                            }
                            return $name==""?$src:$name."(".$src.")";
                        }
                    ],
                    [
                        'attribute'=>'mTypeID',
                        'label'=>'物品名称',
                        'value'=>function($model){
                            $name=\common\helps\ItemDefHelper::getNameById(1,$model['mTypeID']);
                            return $name?$name:$model['mTypeID'];
                        }
                    ],
                    ['attribute'=>'mIdentID','label'=>'物品唯一ID'],
                    ['attribute'=>'mCreateTime','label'=>'创建时间'],
                ],
            ]); ?>
    <?php Pjax::end(); ?>
</div>