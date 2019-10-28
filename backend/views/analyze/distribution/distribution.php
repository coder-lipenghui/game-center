<?php
$this->title="";
$this->registerJsFile("@web/js/echarts.min.js",['position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile("@web/js/analyze/distribution.js",['position'=>\yii\web\View::POS_HEAD]);
$this->registerJs("
showGamesNav()
");
$this->registerCss("
.dtop-items-title {
    display: inline-block;
    height: 66px;
    width: 66px;
    background: url(../../static/game_dash-icons.png) no-repeat;
}
.dtop-items-title.newuser {
    background-position: 0 0;
}
.dtop-items-title.newdevice {
    background-position: 0 -75px;
}
.dtop-items-title.userlogin {
    background-position: 0 -150px;
}
.dtop-items-title.allpay {
    background-position: 0 -301px;
}
.dtop-items-title.arppu {
    background-position: 0 -377px;
}
.dtop-items-title.arpu {
    display: inline-block;
    height: 66px;
    width: 66px;
    background: url(../../static/arpu.png) no-repeat;
}
.label {
    display: inline;
    padding: .2em .6em .3em;
    font-size: 75%;
    font-weight: 700;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: .25em;
}
.label-white {
    position: relative;
    top: -2px;
    border: 1px solid #dedede;
    color: #5e6b7d;
    background-color: #fff;
    font-size: 12px;
    font-weight: 400;
}
.navbar-nav>.user-menu>.dropdown-menu {
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    padding: 1px 0 0 0;
    border-top-width: 0;
    width: 220px;
}
.navbar-nav>.user-menu>.dropdown-menu>li.user-my-header {
    height: 35px;
    padding: 5px;
    color:#FFFFFF;
    text-align: center;
    background-color: #3c8dbc;
}
.navbar-nav>.user-menu>.dropdown-menu>li.user-my-header:hover{
    height: 35px;
    padding: 5px;
    color:#FFFFFF;
    text-align: center;
    background-color: #337ab7;
}
.dropdown-menu > li > a {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: 400;
    line-height: 1.42857143;
    color: #333333;
    white-space: nowrap;
}
");
?>

<div class="panel panel-default">
    <div class="panel-body">
        Top10渠道
        <hr/>
        <div class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default" onclick="showDistributionsRegUser('regUser')">新增账号</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('regDevice')">启动次数</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('loginUser')">活跃用户</button>
            <button type="button" class="btn btn-default" onclick="showDistributionsPayingUser()">付费用户</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('revenue')">付费额度</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('arppu')">次日留存</button>
        </div>
        <div id="DataInfo" style="width: 1200px;height:400px;">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body" id="totalPie" style="width: 600px;height:600px;">

            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body" id="rangePie" style="width: 600px;height:600px;">

            </div>
        </div>
    </div>
</div>
