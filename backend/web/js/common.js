///
/// 公用的JS调用方法：常规的获取游戏、平台、区服等
///
/// create by 李鹏辉
/**
 * 获取游戏列表
 * @param documentid
 * @param async 是否异步获取
 */
function getGame(documentid, async,selectedId,url) {
    var async = arguments[1] ? arguments[1] : false;
    $(documentid).empty();
    $.ajax({
        type: 'post',
        data: {},
        dataType: "json",
        url: (url==null?"":url)+"../permission/get-games",
        async: true,
        success: function(data) {
            $.each(data, function(i) {
                if (data[i].id==selectedId)
                {
                    $("<option selected = 'selected' value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
                }else{
                    $("<option value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
                }

            });
            $(documentid).selectpicker('refresh');
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}

/**
 * 根据游戏ID获取分销渠道
 * @param documentid
 * @param async
 * @param selectedId
 * @param url
 */
function getDistribution(documentid, gid,url) {
    var async = arguments[1] ? arguments[1] : false;
    $(documentid).empty();
    $.ajax({
        type: 'get',
        data: {
            gameId:gid,
        },
        dataType: "json",
        url: (url==null?"":url)+"../permission/get-distribution",
        async: true,
        success: function(data) {
            $.each(data, function(i) {
                // if (data[i].id==selectedId)
                // {
                //     $("<option selected = 'selected' value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
                // }else{
                    var platform="安卓";
                    if (data[i].platform==2)
                    {
                        platform="IOS";
                    }
                    $("<option value='" + data[i].distributionId + "'>" + data[i].distributor + "("+platform+")</option>").appendTo(documentid);
                // }
            });
            $(documentid).selectpicker('refresh');
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}

/**
 * 获取区服列表信息
 * @param documentid 对象
 * @param async 是否异步
 * @param gid 游戏id
 * @param pid 平台id
 * @param url 目录追加
 */
function getServers(documentid,async,gameId,distributorId,selectedid,url) {
    var async = arguments[1] ? arguments[1] : false;
    $(documentid).empty();
    $.ajax({
        type: 'get',
        data: {
            gameId: gameId,
            distributorId: distributorId
        },
        dataType: "json",
        url: (url==null?"":url)+"../permission/get-server",
        async: true,
        success: function(data) {
            $.each(data, function(i) {
                if(selectedid==data[i].id )
                {
                    $("<option selected = 'selected' value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
                }else{
                    $("<option value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
                }
            });
            $(documentid).selectpicker('refresh');
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}
function getDistributor(documentid,async,gameId,selectedId,url) {
    var async = arguments[1] ? arguments[1] : false;
    $(documentid).empty();
    $.ajax({
        type: 'get',
        data: {
            gameId: gameId
        },
        dataType: "json",
        url: (url==null?"":url)+"../permission/get-distributor",
        async: true,
        success: function(data) {
            $.each(data, function(i) {
                if (selectedId==data[i].id)
                {
                    $("<option selected = 'selected' value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
                }else{
                    $("<option value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
                }
            });
            $(documentid).selectpicker('refresh');
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}
function getItems(documentid,gid,url) {
    var async = arguments[1] ? arguments[1] : false;
    $(documentid).empty();
    $.ajax({
        type: 'get',
        data:{
            gameId:gid
        },
        dataType: "json",
        url: (url==null?"":url)+"../permission/get-items",
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