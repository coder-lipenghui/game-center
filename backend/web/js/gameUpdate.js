function handleGameChange() {
    var gameId=$("#gameUpdateGames").val();
    getDistributor("#gameUpdateDistributions",true,gameId,null,"../");
}
function handleVersionChange()
{
    var versionId=$("#gameUpdateVersions").val()
    $.ajax({
        type: 'get',
        data:{
            versionId:versionId
        },
        // dataType: "text",
        url: "../../permission/get-game-update-version",
        async: true,
        success: function(data) {
            $("#tabgameupdate-version").val(Number(data)+1);
            var lastVersion="未更新过";
            if (Number(data)!=0)
            {
                lastVersion="上次版本号为:"+Number(data);
            }
            $("#txtVersion").text(lastVersion);
        },
        error: function(data) {
            $("#txtVersion").text("获取版本信息失败");
        }
    });
}