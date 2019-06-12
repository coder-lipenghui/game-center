function doAdd() {
    var num=parseInt($("#itemNum").val())+1;
    $("#itemNum").val(num);
}
function doSub() {
    var num=parseInt($("#itemNum").val())-1;
    if(num<1)
    {
        num=1;
    }
    $("#itemNum").val(num);
}
function btnOk() {
    var item=$("#selectItems").val();
    var num=$("#itemNum").val();
    var curr=$("#cmdmail-items").val();
    if (curr=="")
    {
        $("#cmdmail-items").val(curr+item+","+num);
    }else{
        $("#cmdmail-items").val(curr+","+item+","+num);
    }
}
function doMailAjaxSubmit() {
    var form=$("#mailForm");
    var formData = form.serialize();
    $.ajax({
        url:"mail",
        type: "get",
        dataType: "json",
        data:formData,
        success:function (data) {
            $("#cmdResult").text(data[0].msg);
            $("#myModal").modal('toggle');
        },
        error:function (msg) {
            alert("请求失败"+msg.code);
        }
    });
}