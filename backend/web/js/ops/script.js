function selectAll(page) {
    var selected=$("#page_selecte_"+page).is(':checked')
    if (selected)
    {
        $(".page_checkbox_"+page).attr('checked',true);
    }else {
        $(".page_checkbox_" + page).attr('checked',false)
    }
}
function updateSomeServer() {
    var gameId=$("#gameId").val();
    var fileName=$("#fileName").val();
    $("#updateInfo").empty();
    var servers=$("input.server_input");
    for (var i=0;i<servers.length;i++)
    {
        var server=servers[i];
        var serverId=$(server).attr('value');
        if ($(server).is(':checked'))
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
                    $("#updateInfo").append("<label class='"+style+"'>["+data.id+":"+data.name+"]:"+data.msg+"</label>");
                },
                error:function (msg) {
                   // console.log("请求出现一场:"+msg)
                }
            });
        }

    }
}
function upateAllServer() {
    
}
function watch(target) {
    console.log($(target).is(':checked'));
}