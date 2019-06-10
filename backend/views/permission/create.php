<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TabPermission */

$this->title = Yii::t('app', '权限分配');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '权限管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("@web/jstree/themes/default/style.min.css",['position'=>\yii\web\View::POS_HEAD,'depends'=>'yii\web\YiiAsset']);
$this->registerJsFile("@web/jstree/jstree.min.js",['position'=>\yii\web\View::POS_HEAD,'depends'=>'yii\web\YiiAsset']);
$this->registerJs('
    $("#users").jstree();
    $("#games").jstree({
        "types":{
            "file" : {
              "icon" : "glyphicon glyphicon-file",
              "valid_children" : []
            }
        },
        "plugins" : [ "wholerow", "checkbox" ]
    });
    $("#distribution").jstree({
        "plugins" : [ "wholerow", "checkbox" ]
    });
');
?>
<div class="table">
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    用户列表
                </div>
                <div class="panel-body">
                    <?= Html::input("input"); ?>
                    <hr/>
                    <div id="users">
                        <ul>
                            <li data-jstree='{"icon":"glyphicon glyphicon-cog"}'>研发
                                <ul>
                                    <li data-jstree='{"icon":"glyphicon glyphicon-chevron-right"}'>管理
                                        <ul>
                                            <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>李鹏辉</li>
                                            <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>赵中杰</li>
                                            <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>杨继忠</li>
                                        </ul>
                                    </li>
                                    <li data-jstree='{"icon":"glyphicon glyphicon-chevron-right"}'>运维
                                        <ul>
                                            <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>吴海涛</li>
                                            <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>葛清龙</li>
                                        </ul>
                                    </li>
                                    <li data-jstree='{"icon":"glyphicon glyphicon-chevron-right"}'>客服
                                        <ul>
                                            <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>王明明</li>
                                            <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>杨润中</li>
                                            <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>孙卉</li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-jstree='{"icon":"glyphicon glyphicon-cog"}'>对外
                                <ul>
                                    <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>管理</li>
                                    <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>运营</li>
                                    <li data-jstree='{"icon":"glyphicon glyphicon-user"}'>客服</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    游戏列表
                </div>
                <div class="panel-body" id="games">
                    <ul>
                        <li data-jstree='{"icon":"glyphicon glyphicon-globe"}'>单职业</li>
                        <li data-jstree='{"icon":"glyphicon glyphicon-globe"}'>烈火王城</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    分销商
                </div>
                <div class="panel-body" id="distribution">
                <ul>
                    <li data-jstree='{"icon":"glyphicon glyphicon-object-align-right"}'>龙翔
                        <ul>
                            <li data-jstree='{"icon":"glyphicon glyphicon-phone"}'>安卓</li>
                            <li data-jstree='{"icon":"glyphicon glyphicon-apple"}'>IOS</li>
                        </ul>
                    </li>
                    <li data-jstree='{"icon":"glyphicon glyphicon-object-align-right"}'>小7</li>
                </ul>
            </div>
        </div>
    </div>
</div>
