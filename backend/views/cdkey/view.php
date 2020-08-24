<?php

use backend\models\TabGameVersion;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\TabGames;
use backend\models\TabDistributor;
use backend\models\TabCdkeyVariety;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\models\TabCdkey */

$this->title = "激活码导出";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '激活码管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/cdk.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJs("
    $('#exportNum').focusout(function(){
        changeHref();
    });
");
?>
<div class="modal fade" id="export" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel">激活码导出</h5>
            </div>
            <input class="hidden" id="exportGameId"/>
            <input class="hidden" id="exportDistributorId"/>
            <input class="hidden" id="exportVarietyId"/>
            <input class="hidden" id="exportSurplus"/>
            <input class="hidden" id="exportUrl"/>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>导出数量:</label>
                    </div>
                    <div class="col-md-8">
                        <input value="" size="20" id="exportNum"/>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" onclick="exportCdkey()">确认</button>
<!--                <a class="btn btn-success" id="exportBtn" href="">确认</a>-->
            </div>
        </div>
    </div>
</div>
<div class="tab-cdkey-view">
    <div class="panel panel-default">

        <?php $form = ActiveForm::begin(); ?>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-1">
                    <?= $form->field($model, 'gameId')->dropDownList(
                        ArrayHelper::map(TabGameVersion::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListVersion",
                            "title"=>"选择版本",
                            "onchange"=>"handleVersionChange()",
                        ]
                    )->label("版本") ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'varietyId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListCDKEYVariety",
                            "title"=>"激活码分类"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'gameId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListGame",
                            "title"=>"选择游戏",
                            "onchange"=>"handleGameChange()"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'distributorId')->dropDownList(
                        [],
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListDistributor",
                            "title"=>"分销商"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="panel-body">
            <?php Pjax::begin(); ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute'=>'varietyId',
                        'label'=>'礼包类型',
                        'value'=>function($data){
                            $variety=TabCdkeyVariety::findOne($data['varietyId']);
                            if(!empty($variety))
                            {
                                return $variety->name;
                            }else{
                                return "未知名称(".$data['varietyId'].")";
                            }
                        }
                    ],
                    [
                        'attribute'=>'surplus',
                        'label'=>'剩余可用',
//                        'value'=>function($data)
//                        {
//                            return ($data['surplus']/10000)."万";
//                        }
                    ],
                    [
                        'attribute'=>'total',
                        'label'=>'激活码数量',
//                        'value'=>function($data)
//                        {
//                            return ($data['total']/10000)."万";
//                        }
                    ],
//                    'gameId',
//                    'distributorId',
                    [
                        'class' => 'common\components\ActionColumn',
                        'template' => '{:export}',
                        'urlCreator'=>function ($action, $model,$key,$index,$column) {
                            $params = $model;
                            $params[0] = $column->controller ? $column->controller . '/' . $action : $action;
                            return Url::toRoute($params);
                        },
                        'buttons' => [
                            'export' => function ($url, $model, $key) {
                                $options = [
                                    'title' => Yii::t('yii', '导出激活码'),
                                    'aria-label' => Yii::t('yii', '导出激活码'),
                                    'data-pjax' => '0',
                                ];
                                $options=[];
                                if ($model['surplus']>0)
                                {
                                    $options=[
                                        'class'=>'btn btn-success btn-sm',
                                        'data-toggle'=>"modal",
                                        'data-target'=>"#export",
                                        'onclick'=>"doExport('$url',".$model['gameId'].",".$model['distributorId'].",".$model['varietyId'].",".$model['surplus'].")"
                                    ];
                                }else{
                                    $options=[
                                        'class'=>'btn btn-success btn-sm',
                                        'disabled'=>'disabled'
                                    ];
                                }
                                return Html::button("导出",$options);
                            },
                        ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
