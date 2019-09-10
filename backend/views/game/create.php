<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\TabGames */

$this->title = Yii::t('app', '新增游戏');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '游戏管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tab-games-create">
    <?php
    $form=ActiveForm::begin();
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            基础信息:
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-1">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'例:刺激战场']) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'sku')->textInput(['maxlength' => true,'placeholder'=>'例:CJZC']) ?>
                </div>
                <div class="col-md-1">
                    <?= $form->field($model, 'logo')->textInput(['maxlength' => true]) ?>
                </div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'info')->textarea(['rows' => 6]) ?>
                </div>
            </div>
            <div class="row">

            </div>
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'createTime')->widget(DateTimePicker::classname(), [

                        'options' => [
                            'placeholder' => '创建时间',
                            'value'=>date('Y-m-d H:i:s',time()),
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                        ]
                    ]); ?>
                </div>
            </div>
            </div>
            <div class="panel-heading">
                <span>游戏服务器登录、发货验证KEY：<small>用在cklogin.php与ckcharge.php中</small></span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <?= $form->field($model, 'loginKey')->textInput(['maxlength' => true,'placeholder'=>'登录验证KEY','value'=>substr(md5(time().'涛哥说不知道用什么规则'),0,20)]) ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($model, 'paymentKey')->textInput(['maxlength' => true,'placeholder'=>'发货验证KEY','value'=>substr(md5(time().'轮子说服务器有一个什么算法'),0,20)]) ?>
                    </div>
                </div>
            </div>
            <div class="panel-heading">
                <span>版号相关</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <?= $form->field($model, 'copyright_number')->textInput(['maxlength' => true,'placeholder'=>'例:新广出审【2019】0001号']) ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($model, 'copyright_isbn')->textInput(['maxlength' => true,'placeholder'=>'例:ISBN 000-0-0000-0000-1']) ?>
                    </div>
                </div>
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-md-2">
                        <?= $form->field($model, 'copyright_press')->textInput(['maxlength' => true,'placeholder'=>'例:北京xxx出版社']) ?>
                    </div>
                    <div class="col-md-2">
                        <?= $form->field($model, 'copyright_author')->textInput(['maxlength' => true,'placeholder'=>'例:北京xxx公司']) ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', '确认添加'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    ActiveForm::end();
    ?>
</div>
