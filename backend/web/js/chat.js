function doTest() {
    //var swf=$("#Chat");
    var swf=document.getElementById("Chat");
    swf.doStringTest("亲测有效...")
}
function doMonitor() {
    var jsonArr=[];
    var servers=$("input.server_input");
    for (var i=0;i<servers.length;i++)
    {
        var server=servers[i];
        var serverId=$(server).attr('value');
        if ($(server).is(':checked'))
        {

            var nn=$("#server_name_"+serverId).val();
            var port=$("#server_port_"+serverId).val();
            var index=$("#server_index_"+serverId).val();
            var url=$("#server_url_"+serverId).val();
            var serverObj={};
            serverObj.id=serverId;
            serverObj.name=nn;
            serverObj.port=port;
            serverObj.url=url;
            serverObj.index=index;
            jsonArr.push(serverObj);
        }
    }
    var json=JSON.stringify(jsonArr)
    console.log(json);
    var swf=document.getElementById("Chat");
    swf.selectServers(json);
}