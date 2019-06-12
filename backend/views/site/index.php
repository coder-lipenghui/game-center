<?php
use yii\helpers\Html;
use yii\widgets\menu;

?>
<?php

/* @var $this yii\web\View */
$this->title = '首页';
//public $secretKey="longcitywebonline12345678901234567890";
//public $ip="111.231.60.73";
//public $port="8310";
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//if (!$socket) {
//    exit(socket_last_error($socket));
//}
////        if (!socket_connect($socket, $this->ip, $this->port)) {
//if (!socket_connect($socket, "111.231.60.73", 8310)) {
//    exit(socket_last_error($socket));
//}
//$in = md5('kick wht'.'longcitywebonline12345678901234567890').'kick wht'.'\n';
//if (!socket_write($socket, $in, strlen($in))) {
//    exit(socket_last_error($socket));
//}
//exit(trim(socket_read($socket, 1024)));
//
//socket_close($socket);
$this->registerJsFile("@web/js/echarts.min.js",['position'=>\yii\web\View::POS_HEAD]);
?>
<?php
if ($msg)
{?>
    <div class="alert alert-danger" role="alert"><?=$msg ?></div>
<?php
} ?>
<div>
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?=($totalToday/1000)."K"; ?></font></font></h3>

                    <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">今日充值</font></font></p>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?=($totalMonth/1000)."K"; ?> </font></font><sup style="font-size: 20px"><font style="vertical-align: inherit;"></font></sup></h3>

                    <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">本月充值</font></font></p>
                </div>
<!--                <div class="icon">-->
<!--                    <i class="ion ion-stats-bars"></i>-->
<!--                </div>-->
<!--                <a href="#" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">更多 </font></font><i class="fa fa-arrow-circle-right"></i></a>-->
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?=$todayRegister;?></font></font></h3>

                    <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">今日新增用户</font></font></p>
                </div>
<!--                <div class="icon">-->
<!--                    <i class="ion ion-person-add"></i>-->
<!--                </div>-->
<!--                <a href="#" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">更多 </font></font><i class="fa fa-arrow-circle-right"></i></a>-->
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><?=$todayOpen ?></font></font></h3>

                    <p><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">今日开服数量</font></font></p>
                </div>
<!--                <div class="icon">-->
<!--                    <i class="ion ion-pie-graph"></i>-->
<!--                </div>-->
<!--                <a href="#" class="small-box-footer"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">更多 </font></font><i class="fa fa-arrow-circle-right"></i></a>-->
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    本月渠道收入
                </div>
                <div class="panel-body">
                    <div id="income" style="width: 400px;height:400px;"></div>
                    <script type="text/javascript">
                        var myChart = echarts.init(document.getElementById('income'));

                        // 指定图表的配置项和数据
                        var option = {
                            // title: {
                            //     text: '各渠道收入概况'
                            // },
                            tooltip: {
                                formatter:"渠道:{b}<br/>收入:{c}元<br/>比例:{d}%"
                            },
                            legend: {
                                data:[<?= date('Y-m',time())?>]
                            },
                            labelLine: {
                                lineStyle: {
                                    color: 'rgba(255, 0, 0, 0.3)'
                                }
                            },
                            series: [{
                                name: '本月收入',
                                type: 'pie',
                                data:<?=json_encode($amountGroupByDistributor,JSON_UNESCAPED_UNICODE);?>
                            }]
                        };
                        myChart.setOption(option);
                    </script>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    各渠道用户数量
                </div>
                <div class="panel-body">
                    <div id="users" style="width: 400px;height:400px;"></div>
                    <script type="text/javascript">
                        var myChart = echarts.init(document.getElementById('users'));

                        // 指定图表的配置项和数据
                        var option = {
                            // title: {
                            //     text: '各渠道收入概况'
                            // },
                            tooltip: {
                                formatter:"渠道:{b}<br/>数量:{c}<br/>比例:{d}%"
                            },
                            legend: {
                                data:[<?= date('Y-m',time())?>]
                            },
                            labelLine: {
                                lineStyle: {
                                    color: 'rgba(255, 0, 0, 0.3)'
                                }
                            },
                            series: [{
                                name: '本月收入',
                                type: 'pie',
                                data:<?=json_encode($userGroupByDistributor,JSON_UNESCAPED_UNICODE);?>
                            }]
                        };
                        myChart.setOption(option);
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    渠道ARPU
                </div>
                <div class="panel-body">
                    <div id="arpu" style="width: 400px;height:400px;"></div>
                    <script type="text/javascript">
                        // 基于准备好的dom，初始化echarts实例
                        var myChart = echarts.init(document.getElementById('arpu'));

                        // 指定图表的配置项和数据
                        var option = {
                            // title: {
                            //     text: '各渠道收入概况'
                            // },
                            tooltip: {},
                            legend: {
                                data:[<?= date('Y-m',time())?>]
                            },
                            xAxis: {
                                data: ["73guo","小7手游","龙翔","趣游","VIVO","OPPO","应用宝","小米","华为"]
                            },
                            yAxis: {},
                            series: [{
                                name: '本月收入',
                                type: 'bar',
                                data: [10000, 50000, 24563, 100298, 1000, 50000,321332,111232,765342]
                            }]
                        };

                        // 使用刚指定的配置项和数据显示图表。
                        myChart.setOption(option);
                    </script>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    渠道ARPPU
                </div>
                <div class="panel-body">
                    <div id="arppu" style="width: 400px;height:400px;"></div>
                    <script type="text/javascript">
                        // 基于准备好的dom，初始化echarts实例
                        var myChart = echarts.init(document.getElementById('arppu'));

                        // 指定图表的配置项和数据
                        var option = {
                            // title: {
                            //     text: '各渠道收入概况'
                            // },
                            tooltip: {},
                            legend: {
                                data:[<?= date('Y-m',time())?>]
                            },
                            xAxis: {
                                data: ["73guo","小7手游","龙翔","趣游","VIVO","OPPO","应用宝","小米","华为"]
                            },
                            yAxis: {},
                            series: [{
                                name: '本月收入',
                                type: 'bar',
                                data: [10000, 50000, 24563, 100298, 1000, 50000,321332,111232,765342]
                            }]
                        };

                        // 使用刚指定的配置项和数据显示图表。
                        myChart.setOption(option);
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
