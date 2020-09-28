<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helps\ItemDefHelper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabCdkeyVarietySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '激活码类型');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-cdkey-variety-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '新增类型'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel panel-body">
                <?php Pjax::begin(); ?>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
//                    ['class' => 'yii\grid\SerialColumn'],
//                    'id',
                    ['attribute'=>'gameId','value'=>'version.name','label'=>'所属版本'],
                    ['attribute'=>'type','value'=>function($model){ return $model->type==1?"普通":"通用";},'label'=>'类型'],
                    'name',
                    ['attribute'=>'items','label'=>'物品内容','value'=>function($model){
                        if ($model['deliverType']==2)
                        {
//                            exit($model['items']);
                            $itemArr= mb_split(",",$model['items']);
                            $itemStr="";
                            for ($i=0;$i<count($itemArr);$i++)
                            {
                                $item=$itemArr[$i];
                                $num="";
                                $name="";
                                if ($i%2==0 && $i>0)
                                {
                                    $num="*".$item;
                                }elseif($i%3==0){
                                    $name=ItemDefHelper::getNameByVersion($model['gameId'],$item);
                                }
                                $itemStr.=$name.$num;
                            }
                            return $itemStr;
                        }else{
                            return ItemDefHelper::getNameByVersion($model['gameId'],$model['items']);
                        }
                    }],
                    'once',
                    ['attribute'=>'deliverType','label'=>'发放方式','value'=>function($model){return $model['deliverType']==1?"脚本":"邮件";}],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
            
                <?php Pjax::end(); ?>
        </div>
    </div>
</div>
