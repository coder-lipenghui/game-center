function showGamesNav() {
    var async = arguments[1] ? arguments[1] : false;
    $('#analyze_games').empty();

    $.ajax({
        type: 'post',
        data: {},
        dataType: "json",
        url:"../../permission/get-game",
        async: true,
        success: function(data) {
            var element='';
            var gameList='<ul class="dropdown-menu">';
            var defaultGameId=0;
            $.each(data, function(i) {
                if (i==0)
                {
                    defaultGameId=data[i].id;
                    element='<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="hidden-xs" id="currGameName">'+data[i].name+'</span><input type="hidden" id="currGameId"/></a>';
                }
                gameList+='<li class="user-my-header" onclick="getDashboardInfo('+data[i].id+',\''+data[i].name+'\')">'+data[i].name+'</li>';
            });
            gameList+='</ul>';
            $('#analyze_games').append(element);
            $('#analyze_games').append(gameList);
            if (defaultGameId>0)
            {
                getDashboardInfo(defaultGameId);
            }
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}
function  getDashboardInfo(gameId,gameName) {
    $("#currGameName").text(gameName);
    $("#currGameId").val(gameId);
    $.ajax({
        type: 'get',
        data: {
            'gameId':gameId
        },
        dataType: "json",
        url:"../dashboard/get-dashboard-info",
        async: true,
        success: function(data) {
            for (var key in data)
            {
                $("#"+key).text(data[key]);
            }
            if (data['totalPayingUser'] && data['totalPayingUser']>0)
            {
                $("#totalArppu").text(data['totalRevenue']/data['totalPayingUser']);
            }else{
                $("#totalArppu").text('0');
            }
            if (data['totalUser'] && data['totalUser']>0)
            {
                $("#totalArpu").text((data['totalRevenue']/data['totalUser']).toFixed(1));
                $("#payingUserProportion").text((data['totalPayingUser']/data['totalUser']*100).toFixed(1)+"%");
            }else{
                $("#totalArpu").text('0');
                $("#payingUserProportion").text('0');
            }
        },
        error:function (data) {
            alert("获取数据失败");
        }
    });
}
function last30dayInfo(type) {
    var gameId=$("#currGameId").val();
    alert(gameId);
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