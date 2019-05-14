
function doAjaxSubmit() {
    var form=$("#itemSearchForm");
    var formData = form.serialize();
    alert(formData);
    $.ajax({
        url:"index",
        type: "post",
        dataType: "json",
        data:formData,
        success:function (data) {
            if (data.items)
            {
                // $("#itemLog tbody").empty();
                // for (var i=0;i<Object.keys(data.items).length;i++)
                // {
                //     var itemJson=data.items[i];
                //     $("#itemLog tbody").append(
                //         "<tr>" +
                //         "<td>"+itemJson.playername+"</td>"+
                //         "<td>"+itemJson.logtime+"</td>"+
                //         "<td>"+itemJson.src+"</td>"+
                //         "<td>"+itemJson.mTypeID+"</td>"+
                //         "<td>"+itemJson.mIdentID+"</td>"+
                //         "<td>"+itemJson.mCreateTime+"</td>"+
                //         "</tr>>");
                // }
            }
        },
        error:function (msg) {
            alert("请求失败"+msg.code);
        }
    });
}
