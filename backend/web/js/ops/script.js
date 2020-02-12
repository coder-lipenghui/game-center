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
    console.log(gameId,fileName);
    var servers=$("input.server_input");
    for (var i=0;i<servers.length;i++)
    {
        var server=servers[i];
        var serverId=$(server).attr('value');
        if ($(server).is(':checked'))
        {
            console.log("正在更新:"+serverId);
            $.ajax({
                url:"../../game-script/update-script",
                type: "post",
                dataType: "json",
                data:{gameId:gameId,scriptName:fileName,serverId:serverId},
                success:function (data) {

                    if (data.code!=1) //失败
                    {
                        // console.log("更新失败："+data.id);
                        $("#server_label_"+data.id).removeClass("label-default");
                        $("#server_label_"+data.id).removeClass("label-success");
                        $("#server_label_"+data.id).addClass("label-danger");

                    }else{
                        console.log("成功："+data.id);
                        $("#server_label_"+data.id).removeClass("label-default");
                        $("#server_label_"+data.id).removeClass("label-danger");
                        $("#server_label_"+data.id).addClass("label-success");
                    }
                },
                error:function (msg) {
                   console.log("请求出现一场:"+msg)
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