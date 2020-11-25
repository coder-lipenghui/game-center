function changeGame(sender,target) {
    getDistributor(target,true,$(sender).val(),null,"../");
    console.log("游戏变化");
    getProducts();
};
function changeDistributor(sender,target1,target2) {
    var gid=$(target1).val();
    var did=$(sender).val();
    getServers(target2,false, gid, did,null,"../");
}
function changeServer(sender) {
    // alert($("#servers").val());
}
function getProducts() {
    var gameId=$("#games").val();
    var documentid="#products";
    $.ajax({
        type: 'get',
        data: {
            gameId:gameId
        },
        dataType: "json",
        url: "../support/product",
        async: true,
        success: function(data) {
            if (data)
            {
                $("<option value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
            }else{
                console.log("数据获取异常");
            }
        },
        error: function(data) {
            console.log("获取数据失败");
        }
    });
}
function createSupport() {
    var form=$("#createSupportForm");
    var formData = form.serialize();
    $.ajax({
        type: 'get',
        data: formData,
        dataType: "json",
        url: "../support/create",
        async: true,
        success: function(data) {
            if (data.code==1)
            {
                $("#myModal").modal("toggle");
            }else{
                alert(data.msg);
            }
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}
function changeType() {
    var type=$("#supportType").val();
    if (type == 0) {
        $("#roleId").removeClass("hidden");
        $("#roleAccount").addClass("hidden");
    }else{
        $("#roleAccount").removeClass("hidden");
        $("#roleId").addClass("hidden");
    }
}