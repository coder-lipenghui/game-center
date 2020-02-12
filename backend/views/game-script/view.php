<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabGameScript */

$this->title = "脚本更新:".$model->fileName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '游戏服务器脚本'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/ops/script.js',['depends'=>'yii\web\YiiAsset']);

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
                ['attribute'=>'gameId','label'=>'所属游戏','options'=>['id'=>'gameId']],
                'fileName',
                'fileSize',
                'userId',
                'comment',
                'logTime:datetime',
            ],
            'options' => ['class' => 'table table-striped table-condensed detail-view'],
            ]) ?>
        </div>
    </div>
    <div class="panel panel-default">
        <?php
            $count=count($servers);
            $page=ceil($count/100);
            $row=10;
            $cel=10;
        ?>
        <div class="panel-heading">
            区服列表
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-default">第1页</button>
                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <?php
                        for ($i=0;$i<$page;$i++)
                        {
                            echo("<li><a href='#'>第".($i+1)."页</a></li>");
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            <?php
                echo("共：".$count."个区&nbsp; 每页100个");
                for ($i=0;$i<$page;$i++)
                {
                    if($i>0)
                    {
                        echo("<div class='server_page page_$i hidden'>");
                    }else{
                        echo("<div class='server_page page_$i'>");
                    }

                    echo("<input type='checkbox' id='page_selecte_$i' onclick='selectAll($i)'>本页全选</input>");
                    echo(" <table class=\"table\">");
                    for ($j=0;$j<$row;$j++)
                    {
                        if ($j>=$count/10)
                        {
                            continue;
                        }
                        echo("<tr>");
                        for ($n=0;$n<$cel;$n++)
                        {
                            $index=($i*($page-1)*100)+$j*$row+$n;
                            echo("<td>");
                            if (!empty($servers[$index]))
                            {
                                $server=$servers[$index];
                                echo("<input onclick='watch(this)' type='checkbox' value='".$server['id']."' class='server_input page_checkbox_$i' id='server_".$server['id']."'><label id='server_label_".$server['id']."' class='label label-default'>".$server['index']."区(".$server['name'].")</label></input>");
                            }
                            echo("</td>");
                        }
                        echo("</tr>");
                    }
                    echo("</table>");
                    echo("</div>");
                }
            ?>
        </div>
        <div class="panel-footer">
            <button class="btn btn-primary" onclick="updateSomeServer()">更新选中</button>
            <button class="btn btn-success" onclick="updateAllServer()">全服更新</button>
        </div>
    </div>
</div>
