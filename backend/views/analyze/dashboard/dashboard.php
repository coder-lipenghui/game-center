<?php
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\menu;
?>
<?php
/* @var $this yii\web\View */
$this->title = '数据概况';
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
$this->registerJsFile("@web/js/echarts.min.js",['position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile("@web/js/analyze/dashboard.js",['position'=>\yii\web\View::POS_HEAD]);
$this->registerJs("
showGamesNav()
$(function () {
  $('[data-toggle=\"tooltip\"]').tooltip()
})
");

?>

<div class="panel panel-default">
    <div class="panel-body">
        <b>实时数据</b>
        <hr>
        <div class="row">
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title newuser"/></p>
                    <p class="text-center">新增账号<p/>
                    <p class="text-center"><span class="label label-white">今日</span><span id="todayRegUser"></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span id="yesterdayRegUser"></span></p>
                </div>
            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title newdevice"/></p>
                    <p class="text-center">新增设备<p/>
                    <p class="text-center"><span class="label label-white">今日</span><span id="todayRegDevice"></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span id="yesterdayRegDevice"></span></p>
                </div>

            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title userlogin"/></p>
                    <p class="text-center">活跃用户<p/>
                    <p class="text-center"><span class="label label-white">今日</span><span id="todayLoginUser"></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span id="yesterdayLoginUser"> -</span></p>
                </div>
            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title allpay"/></p>
                    <p class="text-center">付费额度<p/>
                    <p class="text-center"><span class="label label-white">今日</span><span id="todayRevenue"></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span id="yesterdayRevenue"></span></p>
                </div>
            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title arppu"/></p>
                    <p class="text-center">ARPPU<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="今日充值金额/今日充值用户数"></span><p/>
                    <p class="text-center"><span class="label label-white">今日</span><span id="todayArppu"></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span id="yesterdayArppu">-</span></p>
                </div>
            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title arpu"/></p>
                    <p class="text-center">ARPU<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="今日充值金额/今日登录用户数"></span><p/>
                    <p class="text-center"><span class="label label-white">今日</span><span id="todayArpu"></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span id="yesterdayArpu"> 0</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <label>数据概要</label>
        <hr/>
        <div class="row">
            <div class="col-sm-2">
                <small>累计用户</small>
                <h3 id="totalUser"></h3>
            </div>
            <div class="col-sm-2">
                <small>累计设备</small>
                <h3 id="totalDevice"></h3>
            </div>
            <div class="col-sm-2">
                <small>过去7天活跃用户</small>
                <h3 id="last7dayLoginUser"></h3>
            </div>
            <div class="col-sm-2">
                <small>过去30天活跃用户</small>
                <h3 id="last30dayLoginUser"></h3>
            </div>
            <div class="col-sm-2">
                <small>-</small>
                <h3>-</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <small>累计付费用户</small>
                <h3 id="totalPayingUser"></h3>
            </div>
            <div class="col-sm-2">
                <small>累计付费金额</small>
                <h3 id="totalRevenue"></h3>
            </div>
            <div class="col-sm-2">
                <small>付费率</small>
                <h3 id="payingUserProportion">-</h3>
            </div>
            <div class="col-sm-2">
                <small>arpu</small>
                <h3 id="totalArpu"></h3>
            </div>
            <div class="col-sm-2">
                <small>arppu</small>
                <h3 id="totalArppu"></h3>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <b>最近30日数据趋势图</b>
        <hr/>
        <div class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default" onclick="last30dayInfo('regUser')">新增账号</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('regDevice')">新增设备</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('loginUser')">活跃用户</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('payingUser')">付费用户</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('revenue')">付费额度</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('arppu')">ARPPU</button>
            <button type="button" class="btn btn-default" onclick="last30dayInfo('arpu')">ARPU</button>
        </div>
        <div>
            <div id="last30dayInfo" style="width: 1200px;height:400px;"></div>
        </div>
    </div>
</div>