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

$this->title = Yii::t('app', '物品日志');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/api/itemSearch.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/common.js');
$this->registerJsFile('@web/js/api/dropdown_menu.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/api/itemSearch.js',['depends'=>'yii\web\YiiAsset']);

?>
<div class="panel panel-default">

    <?php
        echo $this->render('_search', ['searchModel' => $searchModel,'games'=>$games,'distributors'=>$distributors,'servers'=>$servers]);
    ?>
    <?php
    Pjax::begin(['id'=>'myTest']);
    ?>
            <?= GridView::widget([
                'id'=>'itemLog',
                'dataProvider' => $dataProvider,
//                'key'=>['gameId'=>$gameId],
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
                                $name = \common\helps\RecordHelper::getNameById($model['gameId'],$model['src']);
                            }catch(Exception $e){

                            }
                            return $name==""?$src:$name."(".$src.")";
                        }
                    ],
                    'mNumber',
                    [
                        'attribute'=>'mTypeID',
                        'label'=>'物品名称',
                        'value'=>function($model){
                            $name=\common\helps\ItemDefHelper::getNameById($model['gameId'],$model['mTypeID']);
                            return $name?$name:$model['mTypeID'];
                        }
                    ],
                    ['attribute'=>'mIdentID','label'=>'物品唯一ID'],
//                    ['attribute'=>'mCreateTime','label'=>'创建时间'],
                    'mCreateTime:datetime'
                ],
            ]); ?>
    <?php Pjax::end(); ?>
</div>