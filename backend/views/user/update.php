<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\TabGames;
use mdm\admin\components\Configs;
/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', '修改: {name} 账号', [
    'name' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', '修改');
$this->registerJsFile("@web/js/user.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJs('
    buildDistributions('.json_encode($distributions).',true);
');
?>
<div class="user-update">
    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            基础信息
        </div>
        <div class="panel-body">
            <table class="table table-condensed">
                <tr>
                    <td class="col-md-1">账号</td>
                    <td><?= $form->field($model, 'username')->textInput(['maxlength' => true,'disabled'=>true])->label(false) ?></td>
                    <td class="col-md-5"></td>
                </tr>
                <tr>
                    <td>密码</td>
                    <td><?= $form->field($model, 'password_hash')->textInput(['maxlength' => true])->label(false) ?></td>
                    <td class="col-md-5"><label class="text-info">显示的是加密后的密码，如果要修改 请直接填写需要修改成的密码</label></td>
                </tr>
                <tr>
                    <td>邮箱</td>
                    <td><?= $form->field($model, 'email')->textInput(['maxlength' => true])->label(false) ?></td>
                    <td class="col-md-5"></td>
                </tr>
            </table>
        </div>
        <div class="panel-heading">
            账号类型
        </div>
        <div class="panel-body">
            <?php
            //当前账号的角色
            $role=Configs::authManager()->getRolesByUser($model->id);
            //角色分类
            $roles=Configs::authManager()->getRoles();
            $checkList=[];
            foreach ($roles as $k=>$v)
            {
                $checkList[$k]=$k;
                if (!empty($role[$k]))
                {
                    $model->role=$k;//选中对应的角色
                }
            }
            echo $form->field($model,"role")->radioList($checkList)->label(false);
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
        <?= Html::submitButton(Yii::t('app', '确认修改'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
