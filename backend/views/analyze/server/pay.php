<?php
use kartik\datetime\DateTimePicker;
$this->title="";
$this->registerJsFile("@web/js/echarts.min.js",['position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile("@web/js/common.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/analyze/server.js",['position'=>\yii\web\View::POS_HEAD]);

use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-1">
                <?= Html::dropDownList("游戏",
                    [],
                    array_merge(["--选择--"],$games),
                    [
                        'class'=>'selectpicker form-control col-md-2',
                        'title'=>'游戏',
                        'id'=>'retainGames',
                        'onchange'=>'changeGame()'
                    ])?>
            </div>
            <div class="col-md-2">
                <?= Html::dropDownList("渠道",
                    [],
                    array_merge(["--选择--"],$games),
                    [
                        'class'=>'selectpicker form-control col-md-2',
                        'title'=>'渠道',
                        'id'=>'retainDistributors',
                        'onchange'=>'changeDistributor()'
                    ])?>
            </div>
            <div class="col-md-2">
                <?= Html::dropDownList("区服",
                    [],
                    [],
                    [
                        'class'=>'selectpicker form-control fit',
                        'title'=>'区服',
                        'id'=>'retainServers1',
                        "data-width"=>"fit"
                    ])?>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary btn-small" onclick="searchPayDashboard()">查询</button>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">概况<small>(开服至今)</small></div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-1">
                <small>付费金额</small>
                <h3 id="totalRevenue">-</h3>
            </div>
            <div class="col-sm-1">
                <small>累计用户</small>
                <h3 id="totalUser">-</h3>
            </div>
            <div class="col-sm-1">
                <small>付费用户</small>
                <h3 id="totalPayUser">-</h3>
            </div>
            <div class="col-sm-1">
                <small>付费率</small>
                <h3 id="payUserProportion">-</h3>
            </div>
            <div class="col-sm-1">
                <small>arppu</small>
                <h3 id="arppu">-</h3>
            </div>
            <div class="col-sm-1">
                <small>arpu</small>
                <h3 id="arpu">-</h3>
            </div>
        </div>


    </div>
    <div class="panel-body hidden">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="#">付费用户</a></li>
            <li role="presentation"><a href="#">付费额度</a></li>
            <li role="presentation"><a href="#">Messages</a></li>
        </ul>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

