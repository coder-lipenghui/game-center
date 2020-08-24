<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\TabGames;
use backend\models\TabDistributor;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabCdkeySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '激活码');
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/cdk.js',['depends'=>'yii\web\YiiAsset']);

?>
<?php
  if ($msg)
  {
?>
      <div class="alert alert-danger" role="alert"><?=$msg ?></div>
<?php

  }
?>
<div class="tab-cdkey-index">
    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('app', '生成激活码'), ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', '激活码导出'), ['view'], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <?php $form = ActiveForm::begin([
            'fieldConfig' => ['template' => '{input}'],
        ]); ?>
        <div class="panel-body">
            <div class="row">

                <div class="col-md-1">
                    <?= $form->field($model, 'gameId')->dropDownList(
                        ArrayHelper::map(TabGames::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListGame",
                            "title"=>"选择游戏"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'distributorId')->dropDownList(
                        ArrayHelper::map(TabDistributor::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListDistributor",
                            "title"=>"分销商"
                        ]
                    ) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'varietyId')->dropDownList(
                        ArrayHelper::map(\backend\models\TabCdkeyVariety::find()->select(['id','name'])->all(),'id','name'),
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"dropDownListCDKEYVariety",
                            "title"=>"激活码种类"
                        ]
                    ) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'cdkey')->textInput(['placeholder'=>'激活码'])?>
                </div>
                <div class="col-md-1">
                    <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-info']) ?>
                </div>
            </div>
        </div>
        <?php
            ActiveForm::end()
        ?>
        <div class="panel-body">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php
                Pjax::begin();
            ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
//                'filterModel' => $model,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

//                    'id',
                    'varietyId',
                    [
                        'attribute'=>'gameId',
                        'value'=>'game.name',
                    ],
                    'distributorId',
//                    'distributionId',
                    'cdkey',
                    [
                        'attribute'=>'used',
                        'format'=>'html',
                        'value'=>function($model){
                            if($model->used==1)
                            {
                                return "<span class='label label-danger'>已使用</span>";
                            }else{
                                return "<span class='label label-default'>未使用</span>";
                            }
                        }
                    ],
                    //'createTime:datetime',

                    [
                        'class' => 'yii\grid\ActionColumn',
                    ],
                ],
            ]); ?>
            <?php
                Pjax::end();
            ?>
        </div>
    </div>
</div>
