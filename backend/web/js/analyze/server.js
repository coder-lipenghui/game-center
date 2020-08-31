function getRetainData(documentId, type,url) {
    $("#"+documentId).empty();
    var gameId=$("#retainGames").val();
    var distributorId=$("#retainDistributors").val();
    var day=$("#singleDays").val();
    var num=$("#latestServers").val();
    var date1=$("#date1").val();
    var date2=$("#date2").val();
    var server1=$("#retainServers1").val();
    var server2=$("#retainServers2").val();
    var date=date1;
    var serverId=server1;
    if (type==3)
    {
        date=date2;
        serverId=server2;
    }
    $.ajax({
        type: 'get',
        data: {
            type:type,
            gameId:gameId,
            distributorId:distributorId,
            serverId:serverId,
            startDate:date,
            day:day,
            num:num
        },
        dataType: "json",
        url: (url==null?"":url)+"../server/get-retain-data",
        async: true,
        success: function(data) {
            if (data.code==1)
            {
                var result=data.data;
                if (type==2)
                {
                    var element="<tr>";
                    element+=buildDataView(data.data)+"</tr>";
                    $("#"+documentId).append($(element));
                }else{
                    $.each(result, function(i) {
                        var server=result[i].value;
                        var element="<tr><td>"+result[i].index+"</td>";
                        element+=buildDataView(server)+"</tr>";
                        $("#"+documentId).append($(element));
                    });
                }

            }else{
                $(documentId).append($("<label>"+data.msg+"</label>"))
            }

        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}

function getPayData(documentId, type,url) {
    $("#"+documentId).empty();
    var gameId=$("#retainGames").val();
    var distributorId=$("#retainDistributors").val();
    var serverId=$("#retainServers1").val();
    $.ajax({
        type: 'get',
        data: {
            type: type,
            gameId: gameId,
            distributorId: distributorId,
            serverId: serverId
        },
        dataType: "json",
        url: (url == null ? "" : url) + "../server/get-pay-data",
        async: true,
        success: function (data) {
            if (data.code==1)
            {
                // $("#consumeTime").val(data.openTime);
                $("#openTime").text("("+data.openTime+"-至今)");
                if (type==1)
                {
                    var userNum=data.data[0];
                    var payUserNum=data.data[1];
                    var revenue=data.data[2]/100;
                    $("#totalUser").text(userNum);
                    $("#totalPayUser").text(payUserNum);
                    $("#totalRevenue").text(revenue);
                    $("#payUserProportion").text(userNum==0?"0":(payUserNum/userNum*100).toFixed(1)+"%");
                    $("#arppu").text(payUserNum==0?"0":(revenue/payUserNum).toFixed(2));
                    $("#arpu").text(userNum==0?"0":(revenue/userNum).toFixed(2));
                }
            }else{
                alert(data.msg);
            }
        }
    });
}
function getConsumeData(url) {
    // $("#lineBar").empty();
    var gameId=$("#retainGames").val();
    var distributorId=$("#retainDistributors").val();
    var serverId=$("#retainServers1").val();
    var consumeTime=$("#consumeTime").val()
    $.ajax({
        type: 'get',
        data: {
            type: 1,
            date:consumeTime,
            gameId: gameId,
            distributorId: distributorId,
            serverId: serverId
        },
        dataType: "json",
        url: (url == null ? "" : url) + "../server/consume-detail",
        async: true,
        success: function (data) {
            console.log(data);
            showConsumeLineBar(data);
        },
        error:function (data) {
            console.log("获取数据失败");
        }
    });
}
function showConsumeLineBar(data) {
    var info=JSON.parse(data);
    var xAxis=[];
    var ci=[];
    var jinzuan=[];
    for(var i=0;i<info.length;i++)
    {
        var tmp=info[i];
        xAxis.push(tmp.itemname);
        ci.push(tmp.number);
        jinzuan.push(tmp.total);
    }
    var myChart = echarts.init(document.getElementById("lineBar"));
    var option = {
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                crossStyle: {
                    color: '#999'
                }
            }
        },
        toolbox: {
            feature: {
                dataView: {show: true, readOnly: false},
                magicType: {show: true, type: ['line', 'bar']},
                restore: {show: true},
                saveAsImage: {show: true}
            }
        },
        legend: {
            data: ['次数', '金钻']
        },
        xAxis: [
            {
                type: 'category',
                data: xAxis,
                axisLabel:{
                    rotate:30
                },
                axisPointer: {
                    type: 'shadow'
                }
            }
        ],
        yAxis:
        [
            {
                type: 'value',
                name: '金钻',
                min: 100,
                // max: 10000,
                interval: 50000,
                axisLabel: {
                    formatter: '{value} 金钻'
                }
            },
            {
                type: 'value',
                name: '次数',
                min: 1,
                // max: 10,
                interval: 10,
                axisLabel: {
                    formatter: '{value} 次'
                }
            }
        ],
        series: [
            {
                name: '金钻',
                type: 'bar',
                data: jinzuan
            },
            {
                name: '次数',
                yAxisIndex: 1,
                type: 'line',
                data: ci
            }
        ]
    };
    myChart.setOption(option);
    myChart.resize();
    window.addEventListener("resize",function(){
        myChart.resize();
    });
}
function searchPayDashboard() {
    getPayData("temp",1,"");
    getConsumeData();
}
function buildDataView(data) {
    var element="";
    $.each(data,function(j) {
        if (j>0 && data[0]>0)
        {
            var retain=data[j]/data[0];
            element+="<td>"+(retain*100).toFixed(1)+"%("+data[j]+")</td>";
        }else{
            element+="<td>"+data[j]+"</td>";
        }
    });
    return element;
}
function changeDistributor() {
    var gameId=$("#retainGames").val();
    var distributorId=$("#retainDistributors").val();
    getServers("#retainServers1",true, gameId, distributorId,null,"../");
    getServers("#retainServers2",true, gameId, distributorId,null,"../");
}

function changeGame() {
    var gameId=$("#retainGames").val();
    getDistributor("#retainDistributors",true,gameId,null,"../");
}
function searchLatestServers() {
    $("#tableTop").removeClass("hidden");
    getRetainData("top10",1,"")
}
function searchSingleDate() {
    $("#tableSingleDate").removeClass("hidden");
    getRetainData("tbSingleDate",2,"")
}
function searchSingleDays() {
    $("#tableSingleDays").removeClass("hidden");
    getRetainData("tbSingleDays",3,"")
}

