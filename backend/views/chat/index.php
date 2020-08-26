<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\TabChatControlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '聊天监控');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset','position'=>View::POS_HEAD]);
$this->registerJsFile('@web/js/swfobject.js',['depends'=>'yii\web\YiiAsset','position'=>View::POS_HEAD]);
$this->registerJsFile('@web/js/ops/script.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/chat.js',['depends'=>'yii\web\YiiAsset']);
$this->registerCss("
    
.child{
//	background-color: grey;
	position:absolute;
	top:26%;
//	left:0;
	right:5%;
//	bottom:0;
//	width: 300px;
//	height:20px;
	margin:auto;
}
");
$this->registerJs("
$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});
");

$this->registerJs("
    var flashvars = {
    };
    var params = {
        menu: 'false',
        scale: 'noScale',
        allowFullscreen: 'true',
        allowScriptAccess: 'always',
        bgcolor: '',
        wmode: 'direct' // can cause issues with FP settings & webcam
    };
    var attributes = {
        id:'Chat'
    };
    swfobject.embedSWF(
        '../swf/Chat.swf',
        'altContent', '100%', '610px', '10.0.0',
        '../swf/expressInstall.swf',
        flashvars, params, attributes);
",View::POS_HEAD);
?>
<div class="tab-chat-control-index">
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-default">
                <?php
                $gameList="";
                $serversDiv="";
                $tmp=0;
                foreach ($servers as $k=>$v)
                {
                    $active="";
                    if ($tmp==0)
                    {
                        $tmp=1;
                        $active="active";
                    }
                    $gameList.=" <li role=\"presentation\" class='$active'>
                   <a href=\"#$k\" aria-controls=\"$k\" role=\"tab\" data-toggle=\"tab\">$k</a>
                   <input type='checkbox' aria-label='' id='page_selecte_$k' class='child game_input' onclick='selectOneGame(\"$k\")'/>
                 </li>";
                    $serversDiv.="<div role=\"tabpanel\" class=\"tab-pane $active\" id=\"$k\">";
                    $serverList="<div class='row'>";
                    foreach ($v as $kk=>$vv)
                    {
                        //$kk index
                        //$vv id
                        $serverList.="<div class=\"col-lg-2\">
                                        <div class=\"input-group\">
                                              <span class=\"input-group-addon\">
                                                <input type=\"checkbox\" onclick='watch(this)' value='".$vv['id']."' class='server_input page_checkbox_$k' id='server_".$vv['id']."' aria-label=\"...\">
                                              </span >
                                            <input id='server_label_".$vv['id']."' type = \"text\" class=\"form-control\" aria-label=\"$k\" value='".$vv['name']."区' readonly=\"readonly\"/>
                                            <input id='server_name_".$vv['id']."' type='hidden' class='server_name' value='".$vv['serverName']."'/>
                                            <input id='server_url_".$vv['id']."' type='hidden' class='server_url' value='".$vv['url']."'/>
                                            <input id='server_port_".$vv['id']."' type='hidden' class='server_name' value='".$vv['port']."'/>
                                            <input id='server_index_".$vv['id']."' type='hidden' class='server_index' value='".$vv['index']."'/>
                                        </div>
                                    </div>
                                    ";
                    }
                    $serversDiv.=$serverList."</div></div>";
                }
                ?>
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                <span class="input-group-addon">
                    <input type="checkbox" aria-label="..." id="selectedAll" onclick="selecteAll()">
                </span>
                                <input type="text" class="form-control" aria-label="..." value="所有游戏">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs" id="myTabs">
                        <?=$gameList?>
                    </ul>

                    <div class="tab-content panel-body">
                        <?=$serversDiv?>
                    </div>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary" onclick="doMonitor()">确 定</button>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel-default">
                <div class="panel-body" id="altContent">
                    <div class="alert alert-warning" role="alert"><a class="alert-link" href="http://www.adobe.com/go/getflashplayer">监控组件需要使用FlashPlayer，点击获取/开启FlashPlayer</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
