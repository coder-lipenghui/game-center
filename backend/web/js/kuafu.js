function getGames()
{
    var versionId=$("#versions").val();
    getGamesByVersion("#kuafuGames",versionId,"../");
}
function getDist() {
    var gameId=$("#server_game").val();
    getDistributor("#server_distributor",true,gameId,null,"../");
}
function getServers() {
    var gameId=$("#server_game").val();
    getDistributor("#server_distributor",true,gameId,null,"../");
}
function remove()
{
    var servers=$("input.assigned");
    var serverIds=[];
    for (var i=0;i<servers.length;i++)
    {
        var server=servers[i];
        if ($(server).is(':checked') || $(server).attr("checked"))
        {
            var serverId=$(server).attr('value');
            serverIds.push(serverId);
        }
    }
    if (serverIds.length<=0)
    {
        return;
    }
    $.ajax({
        url:"../servers-kuafu/remove",
        type: "post",
        dataType: "json",
        data:{servers:serverIds},
        success:function (data) {
            if (data.code==1 ||data.code=="1")
            {
                for (var i=0;i<servers.length;i++)
                {
                    var server=servers[i];
                    if ($(server).is(':checked'))
                    {
                        var div=$(server).parent().parent().parent();
                        div.remove();
                        $(server).removeClass("assigned");
                        $(server).addClass("undistributed");
                        $(server).removeAttr('checked');
                        $(server).prop('checked',false);
                        $("#divUndistributed").append(div);
                    }
                }
            }else{
                alert("移除失败");
            }
        },
        error:function (msg) {
            alert("出现异常:"+msg);
        }
    });
}
function add()
{
    var servers=$("input.undistributed");
    var kfServerId=$("div.in input:first").val();
    var serverIds=[];
    for (var i=0;i<servers.length;i++)
    {
        var server=servers[i];
        if ($(server).is(':checked')  || $(server).attr("checked")==true)
        {
            var serverId=$(server).attr('value');
            serverIds.push(serverId);
        }
    }
    if (serverIds.length<=0 || !kfServerId)
    {
        return;
    }
    $.ajax({
        url:"../servers-kuafu/add",
        type: "post",
        dataType: "json",
        data:{servers:serverIds,kfServerId:kfServerId},
        success:function (data) {
            if (data.code==1 ||data.code=="1")
            {
                for (var i=0;i<servers.length;i++)
                {
                    var server=servers[i];
                    if ($(server).is(':checked'))
                    {
                        var div=$(server).parent().parent().parent();
                        div.remove();
                        $(server).removeClass("undistributed");
                        $(server).addClass("assigned");
                        $(server).removeAttr('checked');
                        $(server).prop('checked',false);
                        $("div.in div:first").append(div);
                    }
                }
            }else{
                alert("分配失败");
            }
        },
        error:function (msg) {
            // console.log("请求出现一场:"+msg)
            alert("出现异常:"+msg);
        }
    });
}