function doExport(url,gameId,distributorId,varietyId,surplus) {
    $("#exportUrl").val(url);
    $("#exportGameId").val(gameId);
    $("#exportDistributorId").val(distributorId);
    $("#exportVarietyId").val(varietyId);
    $("#exportSurplus").val(surplus);
}
function changeHref() {
    var exportNum=$("#exportNum").val();
    var surplus=$("#exportSurplus").val();
    var url=$("#exportUrl").val();
    if (exportNum && exportNum>0)
    {
       $("#exportBtn").attr('href',url+"&num="+Math.min(exportNum,surplus));
    }
}
function handleGameChange() {
    var gameId=$("#cdkeyGames").val();
    getDistributor("#cdkeyDistributors",true,gameId,null,"../");
}
function hnadleDistributorsChange(documentid) {
    var gameId=$("#cdkeyGames").val();
    //var distributorId=$("#cdkeyDistributors").val();
    $(documentid).empty();
    $.ajax({
        type: 'get',
        data: {
            gameId: gameId
        },
        dataType: "json",
        url: "../cdkey-variety/list",
        async: true,
        success: function(data) {
            $.each(data, function(i) {
                $("<option value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
            });
            $(documentid).selectpicker('refresh');
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}