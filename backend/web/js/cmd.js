function changeGame(sender,target) {
    var gid= $(sender).val()
    if (gid>0)
    {
        getDistributor(target,true,$(sender).val(),null,"../");
    }else{
        $(target).empty();
    }

}
function changeDistributor(sender,target1,target2) {
    var gid=$(target1).val();
    var did=$(sender).val();
    getServers(target2,true, gid, did,null,"../");
}
function changeCmd(sender) {
    var cmdId=$(sender).val();
    $(".cmd_comment").addClass("hidden");
    $("#cmd_"+cmdId).removeClass("hidden");
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