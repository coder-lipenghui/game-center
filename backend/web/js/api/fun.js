function showDistribution() {

}

function showBarStackData(data,eid) {
    var contener=document.getElementById(eid+'');
    var datas=[];
    var info=[];
    for (i=1;i<data['legend'].length;i++)
    {
        info[i]=[]
        for(j=0;j<data['info'].length;j++)//10个部位
        {
            info[i][j]=data['info'][j][i];
        }
        var series={
            name: '强'+i,
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
    $("#qianghuaTotal").text("强化分布(记录人数:"+data['total']+")")
    var ww=contener.offsetWidth;
    var hh=contener.offsetHeight;
    var myChart = echarts.init(contener,"",{width:ww,height:hh<100?400:hh});
    var option = {
        tooltip: {
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
                name: '数据分布',
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
                showBarStackData(data,type)
            }else
            {
                showPieData(data,type)
            }
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}
function init() {
    getGame("games", true,null,"../");
}