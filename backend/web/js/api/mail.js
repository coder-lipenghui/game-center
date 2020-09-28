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
function onChangeGame(sender)
{
    getDistributor("#platform",true,$("#games").val(),null,"../");
    getItemsByGame("selectItems",$("#games").val(),"../");
}
function changeType(sender) {
    var selectIndex=$(sender).val()
    if (selectIndex==1)
    {
        $("#playerName").hide();
    }else{
        $("#playerName").show();
    }
}
function btnOk() {
    var item=$("#selectItems").val();
    var num=$("#itemNum").val();
    var curr=$("#cmdmail-items").val();
    var bind=0;
    if ($('#ckBind').is(':checked'))
    {
        bind=1;
    }
    if (curr=="")
    {
        $("#cmdmail-items").val(curr+item+","+num+","+bind);
    }else{
        $("#cmdmail-items").val(curr+","+item+","+num+","+bind);
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
            alert(data[0].msg);
            $("#cmdmail-items").val("");
        },
        error:function (msg) {
            alert("请求失败"+msg.code);
        }
    });
}