<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\TabNotice */

$this->title = Yii::t('app', '新增公告');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '公告管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("@web/js/common.js");
$this->registerJsFile("@web/js/notice.js");
$this->registerJs('$(function(){
    //getGame("#games");
})');
?>

<div class="alert alert-info" role="alert">
    <label class="text-info"><span class="glyphicon glyphicon-exclamation-sign"></span>目前不支持换行操作，有换行的地方请改成换行标签</label>
</div>
<div class="panel panel-default">

    <div class="panel-body">
        <?php
        $form=ActiveForm::begin();
        ?>
        <table class="table table-condensed">
            <tr>
                <td class="col-md-1">游戏</td>
                <td class="col-md-5">
                    <?=$form->field($model,'gameId')->dropDownList(
                        $games,
                        [
                            "class"=>"selectpicker form-control col-xs-2",
                            "data-width"=>"fit",
                            "id"=>"noticeGames",
                            "onchange"=>"handleChangeGame()",
                            "title"=>"选择游戏"
                        ]
                    )->label(false)
                    ?>
                </td>
                <td class="col-md-6"></td>
            </tr>
            <tr>
                <td>分销商</td>
                <td>
                    <?php
                    echo Html::dropDownList("distributors",null,[],[
                        "class"=>"selectpicker form-control col-xs-2",
                        "data-width"=>"fit",
                        "id"=>"noticeDistributors",
                        "onchange"=>"handleChangeDistributor()",
                        "title"=>"分销商"
                    ]);
                    ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>平台</td>
                <td><?= $form->field($model,'distributions')->checkboxList([],['id'=>'noticeDistributions'])->label(false)?></td>
                <td></td>
            </tr>
            <tr>
                <td>标题</td>
                <td> <?= $form->field($model,'title')->textInput()->label(false);?></td>
                <td></td>
            </tr>
            <tr>
                <td>内容</td>
                <td><?= $form->field($model, 'body')->textarea(['rows' => 6])->label(false); ?></td>
                <td></td>
            </tr>
            <tr>
                <td>时间</td>
                <td>
                    <div class="row">
                        <div class="col-md-3">
                            <?= $form->field($model, 'starttime')->widget(DateTimePicker::classname(), [
                                'removeButton' => false,
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                ]
                            ])->label(false); ?>
                        </div>
                        <div class="col-md-3">
                            <?= $form->field($model, 'endtime')->widget(DateTimePicker::classname(), [
                                'removeButton' => false,
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                ]
                            ])->label(false); ?>
                        </div>
                    </div>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>排序</td>
                <td><?= $form->field($model,'rank')->textInput()->label(false);?></td>
                <td></td>
            </tr>
        </table>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', '新 增'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php
        ActiveForm::end();
        ?>
    </div>
</div>
