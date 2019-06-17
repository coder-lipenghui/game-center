function changeGame(sender) {
    getDistributor("#distributors",true,$("#games").val(),null,"../");
};
function changeDistributor(sender) {
    var gid=$("#games").val();
    var did=$("#distributors").val();
    getServers("#servers",true, gid, did,null,"../");
}
function changeServer(sender) {
    // alert($("#servers").val());
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
        $("#roleName").removeClass("hidden");
        $("#roleAccount").addClass("hidden");
    }else{
        $("#roleAccount").removeClass("hidden");
        $("#roleName").addClass("hidden");
    }
}