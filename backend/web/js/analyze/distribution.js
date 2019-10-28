function showDistributionsInfo(gameId) {
    drawLineStackChart('新增账号',gameId,'../distribution/reg-user-by-date-range');
}
function showDistributionsRegUser() {
    var gameId=$("#currGameId").val();
    drawLineStackChart('新增账号',gameId,'../distribution/reg-user-by-date-range');
}
function showDistributionsAppStart() {
    var gameId=$("#currGameId").val();
    drawLineStackChart('启动次数',gameId,'../distribution/reg-user-by-date-range');
}
function showDistributionsLoginUser() {
    var gameId=$("#currGameId").val();
    drawLineStackChart('活跃用户',gameId,'../distribution/paying-user-by-date-range');
}
function showDistributionsPayingUser() {
    var gameId=$("#currGameId").val();
    drawLineStackChart('付费用户',gameId,'../distribution/paying-user-by-date-range');
}
function showDistributionsRevenue() {
    var gameId=$("#currGameId").val();
    drawLineStackChart('付费额度',gameId,'../distribution/reg-user-by-date-range');
}
function showDistributorsPayingUser() {
    // var gameId=$("#currGameId").val();
    // drawPie("近30天",gameId,"","rangePie");
}
function drawLineStackChart(title,gameId,url) {
    $.ajax({
        type: 'get',
        data: {
            'day':60,
            'gameId':gameId,
        },
        dataType: "json",
        url:url,
        async: true,
        success: function(data) {
            var myChart = echarts.init(document.getElementById('DataInfo'));
            var option = {
                title: {
                    text: title
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data:data['legend']
                },
                grid: {
                    left: '3%',
                    right: '4%',
                    bottom: '3%',
                    containLabel: true
                },
                toolbox: {
                    feature: {
                        saveAsImage: {}
                    }
                },
                xAxis: { //日期
                    type: 'category',
                    boundaryGap: false,
                    data: data['date']
                },
                yAxis: {
                    type: 'value'
                },
                series: data['data']
            };
            myChart.setOption(option);
        },
        error:function (data) {
            alert("获取数据失败");
        }
    });
}
function drawPie(title,gameId,url,documentId) {
    var ww=$("#"+documentId).width();
    var hh=$("#"+documentId).height();
    $.ajax({
        type: 'get',
        data: {
            'day': 60,
            'gameId': gameId,
        },
        dataType: "json",
        url: url,
        async: true,
        success: function (data) {
            var myChart = echarts.init(document.getElementById(documentId));
            var option = {
                title: {
                    text: title,
                    subtext: '纯属虚构',
                    x: 'center'
                },
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient: 'vertical',
                    left: 'left',
                    data: ['直接访问', '邮件营销', '联盟广告', '视频广告', '搜索引擎']
                },
                series: [
                    {
                        name: '访问来源',
                        type: 'pie',
                        radius: '55%',
                        center: ['50%', '60%'],
                        data: [
                            {value: 335, name: '直接访问'},
                            {value: 310, name: '邮件营销'},
                            {value: 234, name: '联盟广告'},
                            {value: 135, name: '视频广告'},
                            {value: 1548, name: '搜索引擎'}
                        ],
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                            }
                        }
                    }
                ]
            };
            myChart.setOption(option);
        },
        error: function (data) {
            alert("获取数据失败");
        }
    });
}
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
            var defaultGameName="";
            $.each(data, function(i) {
                if (i==0)
                {
                    defaultGameId=data[i].id;
                    defaultGameName=data[i].name;
                    element='<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="hidden-xs" id="currGameName">'+data[i].name+'</span><input type="hidden" id="currGameId"/></a>';
                }
                gameList+='<li class="user-my-header" onclick="changeGame('+data[i].id+',\''+data[i].name+'\')">'+data[i].name+'</li>';
            });
            gameList+='</ul>';
            $('#analyze_games').append(element);
            $('#analyze_games').append(gameList);
            if (defaultGameId>0)
            {
                changeGame(defaultGameId,defaultGameName);
                showDistributionsInfo(defaultGameId);
            }
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}
function changeGame(gameId,gameName) {
    $("#currGameName").text(gameName);
    $("#currGameId").val(gameId);
}