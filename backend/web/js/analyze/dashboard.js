function getOrderDistribution() {
    var target=document.getElementById('orderDistribution')
    $.ajax({
        type: 'get',
        data: {},
        dataType: "json",
        url:"../dashboard/order-distribution",
        async: true,
        success: function(data) {
            var myChart = echarts.init(target);
            var posList = [
                'left', 'right', 'top', 'bottom',
                'inside',
                'insideTop', 'insideLeft', 'insideRight', 'insideBottom',
                'insideTopLeft', 'insideTopRight', 'insideBottomLeft', 'insideBottomRight'
            ];
            var app={};
            app.configParameters = {
                rotate: {
                    min: -90,
                    max: 90
                },
                align: {
                    options: {
                        left: 'left',
                        center: 'center',
                        right: 'right'
                    }
                },
                verticalAlign: {
                    options: {
                        top: 'top',
                        middle: 'middle',
                        bottom: 'bottom'
                    }
                },
                position: {
                    options: echarts.util.reduce(posList, function (map, pos) {
                        map[pos] = pos;
                        return map;
                    }, {})
                },
                distance: {
                    min: 0,
                    max: 100
                }
            };

            app.config = {
                rotate: 90,
                align: 'left',
                verticalAlign: 'middle',
                position: 'insideBottom',
                distance: 15,
                onChange: function () {
                    var labelOption = {
                        normal: {
                            rotate: app.config.rotate,
                            align: app.config.align,
                            verticalAlign: app.config.verticalAlign,
                            position: app.config.position,
                            distance: app.config.distance
                        }
                    };
                    myChart.setOption({
                        series: [{
                            label: labelOption
                        }, {
                            label: labelOption
                        }, {
                            label: labelOption
                        }, {
                            label: labelOption
                        }]
                    });
                }
            };


            var labelOption = {
                show: true,
                position: app.config.position,
                distance: app.config.distance,
                align: app.config.align,
                verticalAlign: app.config.verticalAlign,
                rotate: app.config.rotate,
                formatter: '{c}  {name|{a}}',
                fontSize: 16,
                rich: {
                    name: {
                        textBorderColor: '#fff'
                    }
                }
            };
            // for(var item in data['series'])
            // {
            //     item['label']=labelOption;
            // }

            // for (var i=0;i<data['series'].length;i++)
            // {
            //     data['series']['label']=labelOption;
            // }
            var option = {
                // color: ['#003366', '#006699', '#4cabce', '#e5323e'],
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    data: data['legend']
                },
                toolbox: {
                    show: true,
                    orient: 'vertical',
                    left: 'right',
                    top: 'center',
                    feature: {
                        mark: {show: true},
                        dataView: {show: true, readOnly: false},
                        magicType: {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                        restore: {show: true},
                        saveAsImage: {show: true}
                    }
                },
                xAxis: [
                    {
                        type: 'category',
                        axisTick: {show: false},
                        data: data['xAxis']
                    }
                ],
                yAxis: [
                    {
                        type: 'value'
                    }
                ],
                series: data['series']
            };
            myChart.setOption(option);
        },
        error:function (data) {

        }
    });

}
function revenuePie(target,data,series,title) {
    var myChart = echarts.init(document.getElementById(target));
    var option = {
        title: {
            text: title,
            // subtext: 'title',
            left: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
            type: 'scroll',
            orient: 'vertical',
            left: 'left',
            data: data
        },
        series: [
            {
                name: '收入(元)',
                type: 'pie',
                radius: '55%',
                center: ['50%', '60%'],
                data: series,
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };
    myChart.setOption(option);
    myChart.resize();
    window.addEventListener("resize",function(){
        myChart.resize();
    });
}
function getMonthlyRevenue() {
    $.ajax({
        type: 'get',
        data: {
            'date':null
        },
        dataType: "json",
        url:"../dashboard/get-monthly-revenue",
        async: true,
        success: function(data) {
            var pieData=[];
            var pieSeries=[];
            var pieTitle="";
            for(var i=0;i<data.length;i++) {
                if (i < data.length - 1) {
                    pieData.push(data[i].gameName);
                    pieSeries.push({
                        name: data[i].gameName,
                        value: data[i].revenue == 0 ? null : data[i].revenue
                    });
                }
            }
            pieTitle=data[data.length-1].revenue == 0?"无充值":data[data.length-1].revenue+"元";

            revenuePie("monthlyPie",pieData,pieSeries,pieTitle);
        },
        error:{

        }
    });
}
function getDashboardInfo() {
    $.ajax({
        type: 'get',
        data: {
            'gameId':1
        },
        dataType: "json",
        url:"../dashboard/get-dashboard-info",
        async: true,
        success: function(data) {
            var pieData=[];
            var pieSeries=[];
            var pieTitle="";
            for(var i=0;i<data.length;i++)
            {
                if (i<data.length-1)
                {
                    pieData.push(data[i].gameName);
                    pieSeries.push({name:data[i].gameName,value:data[i].todayRevenue==0?null:data[i].todayRevenue});
                }
                var td='<tr>'+
                    '<td>'+data[i].gameName+'</td>'+
                    '<td>'+data[i].todayRegUser+'</td>'+
                    '<td>'+data[i].todayLoginUser+'</td>'+
                    '<td>'+data[i].todayRevenue+'</td>'+
                    '<td>'+data[i].todayPayingUser+'</td>'+
                    '<td>'+data[i].todayRevenue/data[i].todayTodayLoginUser+'</td>'+
                    '</tr>'

                $("#dashboard").append(td);

                var td2='<tr>'+
                    '<td>'+data[i].gameName+'</td>'+
                    '<td>'+data[i].totalUser+'</td>'+
                    '<td>'+data[i].totalPayingUser+'</td>'+
                    '<td>'+data[i].totalRevenue+'</td>'+
                    '<td>'+((data[i].totalPayingUser/data[i].totalUser)*100).toFixed(2)+'%</td>'+
                    '</tr>';
                $("#total").append(td2);
            }
            if (data[data.length-1])
            {
                var total=data[data.length-1];
                $("#todayRegUser").text(total.todayRegUser);
                $("#todayLoginUser").text(total.todayLoginUser);
                $("#todayRevenue").text(total.todayRevenue);
                if (total.todayPayingUser==0)
                {
                    $("#todayArppu").text("0");
                }else{
                    $("#todayArppu").text((total.todayRevenue/total.todayPayingUser).toFixed(1));
                }
                if (total.todayLoginUser==0)
                {
                    $("#todayArpu").text("0");
                }else{
                    $("#todayArpu").text((total.todayRevenue/total.todayLoginUser).toFixed(1));
                }
                $("#yesterdayRevenue").text(total.yesterdayRevenue);
                $("#todayPayingUser").text(total.todayPayingUser);
                $("#yesterdayPayingUser").text(total.yesterdayPayingUser);
                $("#yesterdayRegUser").text(total.yesterdayRegUser);
                $("#yesterdayLoginUser").text(total.yesterdayLoginUser);

                pieTitle=data[data.length-1].todayRevenue == 0?"无充值":data[data.length-1].todayRevenue+"元";
            }
            revenuePie('todayPie',pieData,pieSeries,pieTitle);
        },
        error:function (data) {
            alert("获取数据失败");
        }
    });
}

function last30dayInfo(type) {
    var gameId=$("#currGameId").val();
    switch (type) {
        case "arpu":
            getLast30dayArpu(gameId);
            break;
        case "arppu":
            getLast30dayArppu(gameId);
            break;
        case "regUser":
            getLast30dayRegUser(gameId);
            break;
        case "regDevice":
            getLast30dayRegDevice(gameId);
            break;
        case "loginUser":
            getLast30dayLoginUser(gameId);
            break;
        case "payingUser":
            getLast30dayPayingUser(gameId);
            break;
        case "revenue":
            getLast30dayRevenue(gameId);
            break;
    }
}
function  getLast30dayRegUser(gameId) {
    drawLineChart(gameId,"../dashboard/last30day-reg-user")
}
function  getLast30dayRegDevice(gameId) {
    //actionLast30dayRegDevice
    drawLineChart(gameId,"../dashboard/last30day-reg-device")
}
function  getLast30dayPayingUser(gameId) {
    drawLineChart(gameId,"../dashboard/last30day-paying-user")
}
function getLast30dayLoginUser(gameId){
    drawLineChart(gameId,"../dashboard/last30day-login-user")
}
function getLast30dayRevenue(gameId){
    drawLineChart(gameId,"../dashboard/last30day-revenue")
}
function getLast30dayArppu(gameId) {
    //drawLineChart(gameId,"../dashboard/last30day-reg-user")
}
function getLast30dayArpu(gameId) {
    //drawLineChart(gameId,"../dashboard/last30day-reg-user")
}
function drawLineChart(gameId,url) {
    $.ajax({
        type: 'get',
        data: {
            'gameId':gameId
        },
        dataType: "json",
        url:url,
        async: true,
        success: function(data) {
            var xAxis=[];
            var yAxis=[];
            var values=[];
            $.each(data,function (i) {
                xAxis.push(data[i].time);
                values.push(data[i].number);
            });
            var myChart = echarts.init(document.getElementById('last30dayInfo'));
            var option = {
                title: {
                    text: '测试',
                },
                xAxis: {
                    type: 'category',
                    data: xAxis
                },
                yAxis: {
                    type: 'value'
                },
                tooltip: {
                    formatter:"数量:{c}<br/><label class='small'>日期:{b}</label><br/>"
                },
                series: [{
                    data: values,
                    type: 'line'
                }]
            };
            myChart.setOption(option);
        },
        error:function (data) {
            alert("获取数据失败");
        }
    });
}