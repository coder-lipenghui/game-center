<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameScript */

$this->title = "";//"脚本更新:".$model->fileName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '游戏服务器脚本'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/ops/script.js',['depends'=>'yii\web\YiiAsset']);
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
\yii\web\YiiAsset::register($this);
?>
<div class="tab-game-script-view">
    <div class="panel panel-default">
        <div class="panel-heading">脚本信息</div>
        <div class="panel-body">
            <input type="hidden" value="<?=$model->gameId?>" id="gameId"/>
            <input type="hidden" value="<?=$model->fileName?>" id="fileName"/>
            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
//                'id',
                ['attribute'=>'gameId','label'=>'游戏版本'],
                ['attribute'=>'fileName','label'=>'脚本名称'],
                ['attribute'=>'fileSize','label'=>'脚本大小'],
//                'userId',
                ['attribute'=>'comment','label'=>'更新内容'],
                'logTime:datetime',
            ],
            'options' => ['class' => 'table table-striped table-condensed detail-view'],
            ]) ?>
        </div>
    </div>
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
                    $serverList.="<div class=\"col-lg-2\">
                        <div class=\"input-group\">
                              <span class=\"input-group-addon\">
                                <input type=\"checkbox\" onclick='watch(this)' value='".$vv['id']."' class='server_input page_checkbox_$k' id='server_".$vv['id']."' aria-label=\"...\">
                              </span >
                            <input id='server_label_".$vv['id']."' type = \"text\" class=\"form-control\" aria-label=\"$k\" value='".$vv['serverName']."' readonly=\"readonly\"/>
                        </div>
                    </div>
                    ";
                }
                $serversDiv.=$serverList."</div></div>";
            }
        ?>
        <div class="panel-heading">
            <div class="row">
                <div class="col-lg-2">
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
            <button class="btn btn-primary" onclick="updateSomeServer()">更新选中</button>
        </div>
    </div>
    <div class="alert alert-primary alert-default" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div id="updateInfo" style="height:300px;width:100%;overflow:auto;">
        </div>
    </div>
</div>
