<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mdm\admin\models\AuthItem;
use yii\helpers\ArrayHelper;
use backend\models\TabGames;
use backend\models\TabDistribution;
use backend\models\TabDistributor;
/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', '新增账号');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("@web/js/user.js",['depends'=>'yii\web\YiiAsset']);
?>
<?php
    if ($msg)
    {
        echo("<div class='alert alert-error alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong>Warning!</strong> <label class='text-error'>$msg</label>
            </div>
        ");
    }
?>
<div class="user-create">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            基础信息
        </div>
        <div class="panel-body">

            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?>
                </div>
            </div>
        </div>

        <div class="panel-heading">
            账号类型
        </div>
        <div class="panel-body">
            <?php
//            exit(json_encode(\mdm\admin\components\Configs::authManager()->getRoles(),JSON_UNESCAPED_UNICODE));
                $roles=\mdm\admin\components\Configs::authManager()->getRoles();
                $checkList=[];
                foreach ($roles as $k=>$v)
                {
                    $checkList[$k]=$k;
                }
                echo $form->field($model,"role")->radioList($checkList,null)->label(false);
            ?>
        </div>
        <div class="panel-heading">
            权限分配
        </div>
        <div class="panel-body">
            <table class="table table-borderless">
                <tr>
                    <td>游戏列表</td>
                    <td><?=Html::checkbox("selectAllGame",false,['id'=>'selectAllGame','onclick'=>'onGamesClick()'])?>全选</td>
                    <td><?=$form->field($model,"games")->checkboxList(
                            ArrayHelper::map(TabGames::find()->all(),'id','name'),
                            [
                                'id'=>'games',
//                                'name'=>'games[]',
                                'onclick'=>'getDistributorsByGameId()'
                            ])->label(false);?></td>
                </tr>
                <tr>
                    <td>分销渠道</td>
                    <td><?=Html::checkbox("selecteAllDistribution",false,['id'=>'selecteAllDistribution','onclick'=>'onDistributionClick()'])?>全选</td>
                    <td><?=$form->field($model,"distributions")->checkboxList([],['id'=>'distributions'])->label(false)?></td>
                </tr>
                <tr>
                    <td>扶持权限</td>
                    <td><?=$form->field($model,"support")->checkbox()->label(false)?></td>
                    <td></td>
                </tr>
            </table>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', '确认新增'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
