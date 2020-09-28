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
function exportCdkey() {
    var url=$("#exportUrl").val();
    var exportNum=$("#exportNum").val();
    var surplus=$("#exportSurplus").val();
    console.log("url:"+url);
    console.log("导出数量:"+exportNum);
    console.log("剩余数量:"+surplus);
    $.ajax({
        type:'get',
        data:{
            num:Math.min(exportNum,surplus),
        },
        dataType: "json",
        url:url,
        async:true,
        success:function (data) {

            if (data.code==1)
            {
                console.log(data.msg);
                document.location.href =(data.msg);
            }else{
                console.log("出现错误:"+data.code);
            }
        },
        error:function (data) {
            console.log("出现异常")
        }
    });
}
function handleVersionChange() {
    var versionId=$("#dropDownListVersion").val();
    console.log("version id:"+versionId);
    getGamesByVersion("#dropDownListGame",versionId,"../");
    handleGetCdkVariety("#dropDownListCDKEYVariety");
}
function handleGameChange() {
    var gameId=$("#dropDownListGame").val();
    getDistributor("#dropDownListDistributor",true,gameId,null,"../");
}

/**
 * 获取激活码类型:普通、通用
 */
function handleVarietyChange() {
    var varietyId=$("#dropDownListCDKEYVariety").val();
    $.ajax({
        type: 'get',
        data: {
            varietyId: varietyId
        },
        url: "../cdkey-variety/type",
        async: true,
        success: function(data) {
            console.log("data:"+data);
            if (data==1)
            {
                $("#generateNum").empty();
                $("#cdkeyInput").addClass("hidden");
                $("#cdkey").val("自动生成");
            }else{
                $("#generateNum").val(1);
                $("#cdkeyInput").removeClass("hidden");
                $("#cdkey").val("");
            }
        },
        error: function(data) {
            $("#generateNum").empty();
            $("#cdkeyInput").addClass("hidden");
        }
    });
}

/**
 * 获取激活码种类
 * @param documentId
 */
function handleGetCdkVariety(documentId) {
    var versionId=$("#dropDownListVersion").val();
    $(documentId).empty();
    $.ajax({
        type: 'get',
        data: {
            gameId: versionId
        },
        dataType: "json",
        url: "../cdkey-variety/list",
        async: true,
        success: function(data) {
            $.each(data, function(i) {
                $("<option value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentId);
            });
            $(documentId).selectpicker('refresh');
        },
        error: function(data) {
            // alert('获取数据失败');
            console.log("获取数据失败");
        }
    });
}
function handleGenerate() {
    var form=$("#cdkeyGenerate");
    var formData = form.serialize();
    $("#alertDiv").empty();
    $.ajax({
        type:'post',
        data:formData,
        url:'../cdkey/create',
        async: true,
        success: function(data) {
            var alertCalss="alert-success";
            if (data!="success")
            {
                alertCalss="alert-error";
            }
            var alert="<div class='alert alert-dismissible "+alertCalss+"' role='alert' id='generateAlter'>"+
                "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+
                "<label class='text-error' id='generateMsg'>"+data+"</label>"+
                "</div>";
            $("#alertDiv").append(alert);
        },
        error: function(data) {
            var alert="<div class='alert alert-dismissible alert-error' role='alert' id='generateAlter'>"+
                "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+
                "<label class='text-error' id='generateMsg'>出现异常</label>"+
            "</div>";
            $("#alertDiv").append(alert);
        }
    });
}
function handleDeliverTypeChange()
{
    var deliverType=$("#tabcdkeyvariety-delivertype").val()
    if (deliverType==1)
    {
        $("#btnAdd").hide();
    }else{
        $("#btnAdd").show()
    }
}
function handleGameVersionChange()
{
    var versionId=$("#tabcdkeyvariety-gameid").val();
    getItemsByVersion("selectItems",versionId,"../");
}
function addOneItem()
{
    var item=$("#selectItems").val();
    var num=$("#itemNum").val();
    var curr=$("#tabcdkeyvariety-items").val();
    var bind=0;
    if ($('#ckBind').is(':checked'))
    {
        bind=1;
    }
    var deliverType=$("#tabcdkeyvariety-delivertype").val();
    if (deliverType==1)
    {
        $("#tabcdkeyvariety-items").val(item);
    }else{
        if (curr=="")
        {
            $("#tabcdkeyvariety-items").val(curr+item+","+num+","+bind);
        }else{
            if (curr.indexOf(",")<0)
            {
                $("#tabcdkeyvariety-items").val(item+","+num+","+bind);
            }else{
                $("#tabcdkeyvariety-items").val(curr+","+item+","+num+","+bind);
            }
        }
    }
}