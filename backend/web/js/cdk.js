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