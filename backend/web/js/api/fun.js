function showBarStackData(data,eid,prefix,suffix) {
    var contener=document.getElementById(eid+'');
    var datas=[];
    var info=[];
    for (var i=0;i<data['legend'].length;i++)
    {
        info[i]=[];
        for(var j=0;j<data['info'].length;j++)
        {
            info[i][j]=data['info'][j][i];
        }
        var series={
            name: prefix+(i+1)+suffix,
            type: 'bar',
            stack: '总量',
            label: {
                show: true,
                position: 'insideRight'
            },
            data: info[i]
        }
        datas[i]=series
    }
    $("#"+eid+"_Total").text("(记录人数:"+data['total']+")")
    var ww=contener.offsetWidth;
    var hh=contener.offsetHeight;
    var myChart = echarts.init(contener,"",{width:ww,height:hh<100?400:hh});
    var option = {
        tooltip: {
            // formatter: '{a}{b}{c}%',
            trigger: 'axis',
            axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
            }
        },
        legend: {
            data: data['legend']
        },
        grid: {
            left: '4%',
            right: '3%',
            bottom: '3%',
            containLabel: true
        },
        xAxis: {
            type: 'value'
        },
        yAxis: {
            type: 'category',
            data: data['yAxis']
        },
        series: datas
    };
    myChart.setOption(option);
}
function showPieNestData(data,eid) {
    if (eid==10011)
    {
        return;
    }
    var contener=document.getElementById(eid+"");
    var ww=contener.offsetWidth;
    var hh=contener.offsetHeight;
    var myChart = echarts.init(contener,"",{width:ww,height:hh<100?600:hh});
    $("#"+eid+"_total").text("(记录人数:"+data['total']+")")
    var option = {
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b}: {c} ({d}%)'
        },
        legend: {
            orient: 'vertical',
            left: 10,
            data: data['legend']
        },
        series: [
            {
                name: '占比',
                type: 'pie',
                selectedMode: 'single',
                radius: [0, '30%'],

                label: {
                    position: 'inner'
                },
                labelLine: {
                    show: false
                },
                data: data['info'][0]
            },
            {
                name: '占比',
                type: 'pie',
                radius: ['40%', '55%'],
                label: {
                    formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
                    backgroundColor: '#eee',
                    borderColor: '#aaa',
                    borderWidth: 1,
                    borderRadius: 4,
                    // shadowBlur:3,
                    // shadowOffsetX: 2,
                    // shadowOffsetY: 2,
                    // shadowColor: '#999',
                    // padding: [0, 7],
                    rich: {
                        a: {
                            color: '#999',
                            lineHeight: 22,
                            align: 'center'
                        },
                        // abg: {
                        //     backgroundColor: '#333',
                        //     width: '100%',
                        //     align: 'right',
                        //     height: 22,
                        //     borderRadius: [4, 4, 0, 0]
                        // },
                        hr: {
                            borderColor: '#aaa',
                            width: '100%',
                            borderWidth: 0.5,
                            height: 0
                        },
                        b: {
                            fontSize: 16,
                            lineHeight: 33
                        },
                        per: {
                            color: '#eee',
                            backgroundColor: '#334455',
                            padding: [2, 4],
                            borderRadius: 2
                        }
                    }
                },
                data: data['info'][1]
            }
        ]
    };
    myChart.setOption(option);
}
function showPieData(data,eid) {
    var contener=document.getElementById(eid+"");
    var ww=contener.offsetWidth;
    var hh=contener.offsetHeight;
    var myChart = echarts.init(contener,"",{width:ww,height:hh<100?400:hh});
    var option = {
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b}: {c} ({d}%)'
        },
        legend: {
            orient: 'vertical',
            left: 10,
            data: data['legend']
        },
        series: [
            {
                name: '占比',
                type: 'pie',
                radius: ['50%', '70%'],
                avoidLabelOverlap: false,
                label: {
                    show: false,
                    position: 'center'
                },
                emphasis: {
                    label: {
                        show: true,
                        fontSize: '30',
                        fontWeight: 'bold'
                    }
                },
                labelLine: {
                    show: false
                },
                data: data['info']
            }
        ]
    };
    myChart.setOption(option);
}
function getDataByFunUrl(url,type) {
    var gameId=$("#games").val();
    var distributorId=$("#platform").val();
    var serverId=$("#servers").val();
    $.ajax({
        type: 'get',
        data: {
            gameId:gameId,
            distributorId:distributorId,
            serverId:serverId,
            type:type
        },
        dataType: "json",
        url:url,
        async: true,
        success: function(data) {
            if (type==10011)
            {
                showBarStackData(data,type,"强","")
            }
            if(type==10012)
            {
                showBarStackData(data,type,"","级")
            }else
            {
                //showPieData(data,type)
                showPieNestData(data,type)
            }
        },
        error: function(data) {
            // alert('获取数据失败');
            // Console.log("获取数据失败...");
        }
    });
}
function init() {
    getGame("games", true,null,"../");
}
function getServerData() {
    getDataByFunUrl('bar-stack',10011);
    getDataByFunUrl('bar-stack',10012);

    var systems=[
        {"id":10002,"type":"pie","name":"转生"},
        {"id":10003,"type":"pie","name":"图鉴"},
        {"id":10004,"type":"pie","name":"战将"},
        {"id":10005,"type":"pie","name":"圣盾"},
        {"id":10006,"type":"pie","name":"血石"},
        {"id":10007,"type":"pie","name":"护体"},
        {"id":10008,"type":"pie","name":"功勋"},
        {"id":10009,"type":"pie","name":"阅历"},
        {"id":10010,"type":"pie","name":"切割"},
        // {"id":10012,"type":"pie","name":"镶嵌"},
        {"id":10013,"type":"pie","name":"战功"},
        // {"id":10014,"type":"pie","name":"历练"},
        {"id":10015,"type":"pie","name":"披风"},
        {"id":10016,"type":"pie","name":"坐骑"}
    ];

    for (var i=0;i<systems.length;i++)
    {
        getDataByFunUrl(systems[i].type,systems[i].id);
    }
}