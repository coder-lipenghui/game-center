<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\TabGames;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\TabGameUpdate */

$this->title = Yii::t('app', '新增更新');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '游戏更新管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("@web/js/common.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/gameUpdate.js",['depends'=>'yii\web\YiiAsset']);
?>

<div class="tab-game-update-create">
    <?php echo $this->render('_explain', []);?>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
            <table class="table table-condensed">
                <tr>
                    <td class="col-md-1">游戏：</td>
                    <td class="col-md-2">
                        <?= $form->field($model, 'gameId')->dropDownList(
                            ArrayHelper::map(TabGames::find()->select(['id','name'])->all(),'id','name'),
                            [
                                'title'=>'选择游戏',
                                'id'=>'gameUpdateGames',
                                'onchange'=>'handleGameChange()',
                                "class"=>"selectpicker form-control col-xs-2",
                            ])->label(false) ?>
                    </td>
                    <td>备注</td>
                </tr>
                <tr>
                    <td>渠道：</td>
                    <td>
                        <?= $form->field($model, 'distributionId')->dropDownList([],
                            [
                                'id'=>'gameUpdateDistributions',
                                'title'=>'选择渠道',
                                "class"=>"selectpicker form-control col-xs-2",
                            ])->label(false) ?>
                    </td>
                    <td><label class="text-info">非必选,如果某个渠道需要单独维护则需要制定分销渠道ID</label></td>
                </tr>
                <tr class="warning">
                    <td>version：</td>
                    <td>
                        <?= $form->field($model, 'versionFile')->textInput(['maxlength' => true])->label(false) ?>
                    </td>
                    <td>.manifest</td>
                </tr>
                <tr class="warning">
                    <td>project：</td>
                    <td>
                        <?= $form->field($model, 'projectFile')->textInput(['maxlength' => true])->label(false) ?>
                    </td>
                    <td>.manifest</td>
                </tr>
                <tr>
                    <td>版本号：</td>
                    <td>
                        <?= $form->field($model, 'version')->textInput(['maxlength' => true])->label(false) ?>
                    </td>
                    <td></td>
                </tr>
                <tr class="vertical-align: middle">
                    <td>更新时间：</td>
                    <td>
                        <?= $form->field($model, 'executeTime')->widget(DateTimePicker::classname(), [
                            'removeButton' => false,
                            'options' => [
                                'placeholder' => '更新时间',
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'startView'=>2,     //起始范围（0:分 1:时 2:日 3:月 4:年）
                                'maxView'=>4,       //最大选择范围（年）
                                'minView'=>0,       //最小选择范围（年）
                            ]
                        ])->label(false); ?>
                    </td>
                    <td>未到时间不会开启更新</td>
                </tr>
<!--                <tr>-->
<!--                    <td>是否启用：</td>-->
<!--                    <td>-->
<!--                        --><?//= $form->field($model, 'enable')->textInput()->label(false) ?>
<!--                    </td>-->
<!--                    <td></td>-->
<!--                </tr>-->
                <tr>
                    <td>SVN记录：</td>
                    <td>
                        <?= $form->field($model, 'svn')->textInput(['maxlength' => true])->label(false) ?>
                    </td>
                    <td>SVN版本号</td>
                </tr>
                <tr>
                    <td>备注：</td>
                    <td>
                        <?= $form->field($model, 'comment')->textInput(['maxlength' => true])->label(false) ?>
                    </td>
                    <td></td>
                </tr>
            </table>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', '确认新增'), ['class' => 'btn btn-success']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
