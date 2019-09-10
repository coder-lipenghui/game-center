<?php
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\menu;
?>
<?php
/* @var $this yii\web\View */
$this->title = '';
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
");
$this->registerJsFile("@web/js/echarts.min.js",['position'=>\yii\web\View::POS_HEAD]);
$this->registerJs("
$(function () {
  $('[data-toggle=\"tooltip\"]').tooltip()
})
");
//exit(json_encode($last30PayingUser));
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
                    <p class="text-center"><span class="label label-white">今日</span><span> <?=$todayRegister?></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span> <?=$yesterdayRegister?></span></p>
                </div>
            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title newdevice"/></p>
                    <p class="text-center">新增设备<p/>
                    <p class="text-center"><span class="label label-white">今日</span><span> <?=$totalTodayRegDevice?></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span> <?=$totalYesterdayRegDevice?></span></p>
                </div>

            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title userlogin"/></p>
                    <p class="text-center">活跃用户<p/>
                    <p class="text-center"><span class="label label-white">今日</span><span> <?=$todayLoginUserNumber?></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span> -</span></p>
                </div>
            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title allpay"/></p>
                    <p class="text-center">付费额度<p/>
                    <p class="text-center"><span class="label label-white">今日</span><span> <?=$totalToday?></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span> <?=$totalYesterday?></span></p>
                </div>
            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title arppu"/></p>
                    <p class="text-center">ARPPU<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="今日充值金额/今日充值用户数"></span><p/>
                    <p class="text-center"><span class="label label-white">今日</span><span> <?=$todayArppu?></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span>-</span></p>
                </div>
            </div>
            <div class="col-md-2">
                <div>
                    <p class="text-center"><span class="dtop-items-title arpu"/></p>
                    <p class="text-center">ARPU<span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="今日充值金额/今日登录用户数"></span><p/>
                    <p class="text-center"><span class="label label-white">今日</span><span> <?=$todayArpu?></span></p>
                    <p class="text-center"><span class="label label-white">昨日</span><span> 0</span></p>
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
                <h3><?=$userTotal?></h3>
            </div>
            <div class="col-sm-2">
                <small>累计设备</small>
                <h3><?=$deviceTotal?></h3>
            </div>
            <div class="col-sm-2">
                <small>过去7天活跃用户</small>
                <h3><?=$last7dayLoginUserNumber?></h3>
            </div>
            <div class="col-sm-2">
                <small>过去30天活跃用户</small>
                <h3><?=$last30dayLoginUserNumber?></h3>
            </div>
            <div class="col-sm-2">
                <small>-</small>
                <h3>-</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <small>累计付费用户</small>
                <h3><?=$payingUserTotal?></h3>
            </div>
            <div class="col-sm-2">
                <small>累计付费金额</small>
                <h3><?=$amountTotal?></h3>
            </div>
            <div class="col-sm-2">
                <small>付费率</small>
                <h3>1</h3>
            </div>
            <div class="col-sm-2">
                <small>arpu</small>
                <h3><?=sprintf("%.2f",($amountTotal/($userTotal==0?1:$userTotal)))?></h3>
            </div>
            <div class="col-sm-2">
                <small>arppu</small>
                <h3><?=sprintf("%.2f",($amountTotal/($payingUserTotal==0?1:$payingUserTotal)))?></h3>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <b>最近30日数据趋势图</b>
        <hr/>
        <div class="btn-group" role="group" aria-label="...">
            <button type="button" class="btn btn-default">新增账号</button>
            <button type="button" class="btn btn-default">新增设备</button>
            <button type="button" class="btn btn-default">活跃用户</button>
            <button type="button" class="btn btn-default">付费用户</button>
            <button type="button" class="btn btn-default">付费额度</button>
            <button type="button" class="btn btn-default">ARPPU</button>
            <button type="button" class="btn btn-default">ARPU</button>
        </div>
<!--        <ul class="nav nav-tabs">-->
<!--            <li role="presentation" class="active"><a href="#">新增账号</a></li>-->
<!--            <li role="presentation"><a href="#">新增设备</a></li>-->
<!--            <li role="presentation"><a href="#">活跃用户</a></li>-->
<!--            <li role="presentation"><a href="#">付费用户</a></li>-->
<!--            <li role="presentation"><a href="#">付费额度</a></li>-->
<!--            <li role="presentation"><a href="#">ARPPU</a></li>-->
<!--            <li role="presentation"><a href="#">ARPU</a></li>-->
<!--        </ul>-->
        <div>
            <div id="last30RegUser" style="width: 1200px;height:400px;"></div>
            <script type="text/javascript">
                <?php
                    $keys=[];
                    $values=[];
                    for ($i=0;$i<count($last30RegUser);$i++)
                    {
                        $keys[]=$last30RegUser[$i]['time'];
                        $values[]=$last30RegUser[$i]['number'];
                    }
                ?>
                var myChart = echarts.init(document.getElementById('last30RegUser'));
                var option = {
                    title: {
                        text: '新增账号',
                    },
                    xAxis: {
                        type: 'category',
                        data: <?=json_encode($keys)?>
                    },
                    yAxis: {
                        type: 'value'
                    },
                    tooltip: {
                       formatter:"数量:{c}<br/><label class='small'>日期:{b}</label><br/>"
                    },
                    series: [{
                        data: <?=json_encode($values)?>,
                        type: 'line'
                    }]
                };
                myChart.setOption(option);
            </script>

            <div id="last30RegDevice" style="width: 1200px;height:400px;"></div>
            <script type="text/javascript">
                <?php
                $keys=[];
                $values=[];
                for ($i=0;$i<count($last30RegDevice);$i++)
                {
                    $keys[]=$last30RegDevice[$i]['time'];
                    $values[]=$last30RegDevice[$i]['number'];
                }
                ?>
                var myChart = echarts.init(document.getElementById('last30RegDevice'));
                var option = {
                    title: {
                        text: '新增设备',
                    },
                    xAxis: {
                        type: 'category',
                        data: <?=json_encode($keys)?>
                    },
                    yAxis: {
                        type: 'value'
                    },
                    tooltip: {
                        formatter:"数量:{c}<br/><label class='small'>日期:{b}</label><br/>"
                    },
                    series: [{
                        data: <?=json_encode($values)?>,
                        type: 'line'
                    }]
                };
                myChart.setOption(option);
            </script>
            <div id="last30Income" style="width: 1200px;height:400px;"></div>
            <script type="text/javascript">
                <?php
                $keys=[];
                $values=[];
                for ($i=0;$i<count($last30Amount);$i++)
                {
                    $keys[]=$last30Amount[$i]['time'];
                    $values[]=$last30Amount[$i]['amount'];
                }
                ?>
                var myChart = echarts.init(document.getElementById('last30Income'));
                var option = {
                    title: {
                        text: '付费额度',
                    },
                    xAxis: {
                        type: 'category',
                        data: <?=json_encode($keys)?>
                    },
                    yAxis: {
                        type: 'value'
                    },
                    tooltip: {
                        formatter:"金额:{c}<br/><label class='small'>日期:{b}</label><br/>"
                    },
                    series: [{
                        data: <?=json_encode($values)?>,
                        type: 'line'
                    }]
                };
                myChart.setOption(option);
            </script>

            <div id="last30PayingUser" style="width: 1200px;height:400px;"></div>
            <script type="text/javascript">
                <?php
                $keys=[];
                $values=[];
                for ($i=0;$i<count($last30PayingUser);$i++)
                {
                    $keys[]=$last30PayingUser[$i]['time'];
                    $values[]=$last30PayingUser[$i]['number'];
                }
                ?>
                var myChart = echarts.init(document.getElementById('last30PayingUser'));
                var option = {
                    title: {
                        text: '付费用户数',
                    },
                    xAxis: {
                        type: 'category',
                        data: <?=json_encode($keys)?>
                    },
                    yAxis: {
                        type: 'value'
                    },
                    tooltip: {
                        formatter:"数量:{c}<br/><label class='small'>日期:{b}</label><br/>"
                    },
                    series: [{
                        data: <?=json_encode($values)?>,
                        type: 'line'
                    }]
                };
                myChart.setOption(option);
            </script>
        </div>
    </div>
</div>
<script>

</script>