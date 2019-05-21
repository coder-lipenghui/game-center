<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabAreasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '角色信息查询');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/api/roleSearch.js',['depends'=>'yii\web\YiiAsset']);
?>
<div class="panel panel-default">
    <?php
    echo $this->render('../commonSearch', ['searchModel' => $searchModel,'games'=>$games]);
    ?>
    <div class="panel-heading"><label>常规操作</label></div>
    <div class="panel-body">
        <button id="btnTest" class="btn btn-info" onclick="">恢复角色</button>
        <button class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="getPlayerName()">强制下线</button>
        <button class="btn btn-info">申请元宝</button>
        <button class="btn btn-info">物品日志</button>
        <button class="btn btn-info">元宝日志</button>
        <button class="btn btn-info">交易日志</button>
        <button class="btn btn-info">死亡日志</button>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">确认将玩家踢下线吗？</h4>
                    </div>

                    <div class="modal-body" id="kick_playerName">
                        <?php
                        $kickForm=ActiveForm::begin([
                            'id'=>'kickForm',
                            'action'=>'cmd/kick',
                            'method'=>'post',
                            'options'=>['class'=>'form-inline']
                        ]);
                        echo $kickForm->field($kickModel,'playerName')->textInput(['placeholder'=>'角色名称','disabled'=>'disabled']);
                        ActiveForm::end();
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" onclick="submitKick()">确认</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
    </div>
    <div class="panel-heading" onclick=""><label>基础信息</label></div>
    <div class="panel-body">
        <div class="row">
            <div class="row">
                <div class="col-md-3">
                    <table class="table table-striped table-bordered" id="roleList">
                        <thead>
                            <tr>
                                <td>角色列表</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>筛选后显示</td>
                            </tr>
                        </tbody>
                    </table>
                    <ul class="pagination hidden">
                        <li class="prev disabled"><a href="#"><</a></li>
                        <li class="next disabled"><a href="#">></a></li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <ul class="nav nav-tabs" id="tabRoleInfo">
                        <li role="presentation" class="active"><a href="javascript:;" onclick="handlerTabSelected(this,'baseAttribute')">玩家属性</a></li>
                        <li role="presentation" ><a href="javascript:;" onclick="handlerTabSelected(this,'itemsAttribute')">玩家物品</a></li>
                        <li role="presentation" ><a href="javascript:;" onclick="handlerTabSelected(this,'paramsAttribute')">玩家变量</a></li>
                    </ul>
                    <div class="row hidden">
                        <table class="table table-condensed roleAttribute" id="cloneAttrTarget">
                            <tr>
                                <td>名称:<label class="chrname"></label></td>
                                <td>账号:<label class="account"></label></td>
                                <td>渠道:<label class="account"></label></td>
                            </tr>
                            <tr>
                                <td>创建:<label class="create_time"></label></td>
                                <td>登入:<label class="last_login_time"></label></td>
                                <td>登出:<label class="last_logout_time"></label></td>
                            </tr>
                            <tr>
                                <td>等级:<label class="lv"></label></td>
                                <td>金币:<label class="money"></label></td>
                                <td>元宝:<label class="vcoin"></label></td>
                            </tr>
                            <tr>
                                <td>职业:<label class="job"></label></td>
                                <td>性别:<label class="gender"></label></td>
                                <td>行会:<label class="guild"></td>
                            </tr>
                            <tr>
                                <td>血量:<label class="cur_hp"></label></td>
                                <td>蓝量:<label class="cur_mp"></label></td>
                                <td>战神:<label class="herolv"></label></td>
                            </tr>
                        </table>
                    </div>
                    <div>

                    </div>
                    <div class="row hidden">
                        <table class="roleWears" border="1" id="cloneWearsTarget">
                            <tr>
                                <td class="pos_-4" width="50" height="50"></td>
                                <td colspan="4"></td>
                                <td class="pos_-8" width="50" height="50"></td>
                            </tr>
                            <tr>
                                <td class="pos_-6" width="50" height="50"></td>
                                <td colspan="4"></td>
                                <td class="pos_-14" width="50" height="50"></td>
                            </tr>
                            <tr>
                                <td class="pos_-12" width="50" height="50"></td>
                                <td colspan="4"></td>
                                <td class="pos_-13" width="50" height="50"></td>
                            </tr>
                            <tr>
                                <td class="pos_-10" width="50" height="50"></td>
                                <td class="pos_"></td>
                                <td colspan="2"></td>
                                <td class="pos_"></td>
                                <td class="pos_-11" width="60" height="60"></td>
                            </tr>
                            <tr>
                                <td class="pos_-18" width="60" height="60"></td>
                                <td class="pos_-28" width="60" height="60"></td>
                                <td class="pos_-22" width="60" height="60"></td>
                                <td class="pos_-24" width="60" height="60"></td>
                                <td class="pos_-26" width="60" height="60"></td>
                                <td class="pos_-20" width="60" height="60"></td>
                            </tr>
                        </table>
                        <table class=""  id="cloneBagTarget">
                        </table>
                        <table class="" id="cloneDepotTarget">
                        </table>
                    </div>
                    <div id="baseAttribute" class="roleTable">
                        玩家属性
                    </div>
                    <div id="itemsAttribute" class="roleTable">
                        <div class="row">
                            <div class="col-md-1">
                                <ul class="nav nav-pills" id="tabPosition">
                                    <li role="presentation" class="active"><a href="javascript:;" onclick="handlerTabPosSelected(this,'wears')">穿戴</a></li>
                                    <li role="presentation"><a href="javascript:;" onclick="handlerTabPosSelected(this,'bag')">背包</a></li>
                                    <li role="presentation"><a href="javascript:;" onclick="handlerTabPosSelected(this,'depot')">仓库</a></li>
                                </ul>
                            </div>
                            <div class="col-md-11">
                               <div class="row" id="roleWears">
                                    身上物品
                               </div>
                                <div class="row" id="roleBag">
                                    背包物品
                                </div>
                                <div class="row" id="roleDepot">
                                    仓库物品
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="paramsAttribute" class="roleTable hidden">
                        暂时还没有
                    </div>

                    <div class="panel-info">
                        <div class="panel-heading">充值信息</div>
                        <div class="panel-body">
                            订单数量，单比最大充值，平均每次充值等各种乱七八糟的信息
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
