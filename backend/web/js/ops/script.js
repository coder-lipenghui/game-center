function selecteAll() {
    var selected=$("#selectedAll").is(':checked')
    if (selected)
    {
        $("input.server_input").attr('checked',true);
        $("input.game_input").attr('checked',true);
    }else {
        $("input.server_input").attr('checked',false);
        $("input.game_input").attr('checked',false);
    }
}

function selectOneGame(page) {
    var selected=$("#page_selecte_"+page).is(':checked')
    if (selected)
    {
        $(".page_checkbox_"+page).attr('checked',true);
    }else {
        $(".page_checkbox_" + page).attr('checked',false)
    }
}

function updateSomeServer(updateAll) {
    var gameId=$("#gameId").val();
    var fileName=$("#fileName").val();
    $("#updateInfo").empty();
    var servers=$("input.server_input");
    for (var i=0;i<servers.length;i++)
    {
        var server=servers[i];
        var serverId=$(server).attr('value');
        if ($(server).is(':checked') || updateAll)
        {
            $.ajax({
                url:"../../game-script/update-script",
                type: "post",
                dataType: "json",
                data:{gameId:gameId,scriptName:fileName,serverId:serverId},
                success:function (data) {
                    var style="text-success";
                    if (data.code!=1) //失败
                    {
                        $("#server_label_"+data.id).removeClass("label-default");
                        $("#server_label_"+data.id).removeClass("label-success");
                        $("#server_label_"+data.id).addClass("label-danger");
                        style='text-error'
                    }else{
                        $("#server_label_"+data.id).removeClass("label-default");
                        $("#server_label_"+data.id).removeClass("label-danger");
                        $("#server_label_"+data.id).addClass("label-success");
                    }
                    $("#updateInfo").append("<label class='"+style+"'>["+data.game+"]["+data.name+"]:</label>"+data.msg+"<br/>");
                },
                error:function (msg) {
                   // console.log("请求出现一场:"+msg)
                }
            });
        }

    }
}

function updateAllServer() {
    // updateSomeServer(true)
}
function watch(target) {
    // console.log($(target).is(':checked'));
}