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
function showSingleData(data) {
    
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
    //TODO 展示数据
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