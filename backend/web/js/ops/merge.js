function handleGameChange() {
    var gameId=$("#mergeGames").val();
    getDistributor("#mergeDistributors",true,gameId,null,"../");
}
function handleDistributorChange() {
    var gameId=$("#mergeGames").val();
    var distributorId=$("#mergeDistributors").val();
    getServers("#sourceServer",true,gameId,distributorId,null,"../");
    getServers("#targetServer",true,gameId,distributorId,null,"../");
}

function doMerge() {
    if (check()) {
        if (checkServer())
        {
            var radios = $("name:MergerModel[type]");
            var step = [];
            var operationSelected = false;
            $('input[name="MergerModel[type]"]').each(function(){
                if ($(this).is(':checked')) {
                    operationSelected = true;
                    if ($(this).val() == 0) {
                        var operation = $("#operation").val();
                        switch (operation) {
                            case '1':
                                step = [['package', '打包数据']];
                                break;
                            case '2':
                                step = [['merge', '合并数据']];
                                break;
                            case '3':
                                step = [['rename', '处理重名']];
                                break;
                            default:
                                alert("未知操作:" + operation);
                                break;
                        }
                    } else {
                        step = [
                            ['package', '打包数据'],
                            ['merge', '合并数据'],
                            ['rename', '处理重名']
                        ];
                    }
                }
            });
            mergeStep(step, 0);
        }else{
            alert("主动区、被动区需不相同");
        }
    }else{
        alert("请选择必要选项");
    }
}
function checkServer() {
    var s1=$("#sourceServer").val();
    var s2=$("#targetServer").val();
    if (s1 == s2)
    {
        return false;
    }
    return true;
}
function check() {
    var operationSelected=false;
    $('input[name="MergerModel[type]"]').each(function () {
        if ($(this).is(':checked'))
        {
            operationSelected=true;
        }
    });
    var gameSelected=$("#mergeGames").val();
    var distributorSelected=$("#mergeDistributors").val();
    var serverSelected=false;
    var s1=$("#sourceServer").val();
    var s2=$("#targetServer").val();
    if (s1 && s2)
    {
        serverSelected=true;
    }
    return operationSelected&&gameSelected&&distributorSelected&&serverSelected;
}
function handlerChangeType() {
    $('input[name="MergerModel[type]"]').each(function () {
        if ($(this).is(':checked'))
        {
            if ($(this).val()==0)
            {
                $("#operationTr").removeClass("hidden");
            }else{
                $("#operationTr").addClass("hidden");
            }
        }
    });
}
function cleanMsgBoxClass() {
    $("#msgBox").removeClass("alert-info");
    $("#msgBox").removeClass("alert-success");
    $("#msgBox").removeClass("alert-error");
    $("#msgBox").removeClass("alert-warning");

    $("#msgBoxText").removeClass("text-info");
    $("#msgBoxText").removeClass("text-success");
    $("#msgBoxText").removeClass("text-error");
    $("#msgBoxText").removeClass("alert-warning");
}
function showMsgBox(text,className) {
    cleanMsgBoxClass();
    $("#msgBox").addClass("alert-"+className);
    $("#msgBoxText").addClass("text-"+className);
    $("#msgBoxText").text(text);
}
function mergeStep(stepArr,step) {
    var warning=[];
    if (stepArr[step])
    {
        $("#btnSubmit").attr("disabled",true);
        $("#btnSubmit").text(stepArr[step][1]+"...");
        // $("#msgBox").text(stepArr[step][1]+"...");
        showMsgBox(stepArr[step][1]+"...",'info');
        var form=$("#myform");
        var formData = form.serialize();
        $.ajax({
            url:stepArr[step][0],
            type: "get",
            dataType: "json",
            data:formData,
            success:function (data) {
                step++;
                if (data.code!=1) //失败
                {
                    showMsgBox(data.msg,"error");
                }else{
                    if (data.msg!="success")
                    {
                        warning.push(data.msg);
                    }
                    if (stepArr[step]) //成功，存在下一步
                    {
                        mergeStep(stepArr,step);
                    }else{ //成功 没有需要继续执行的步骤
                        $("#btnSubmit").attr("disabled",false);
                        $("#btnSubmit").text("确认合区");
                        if (warning.length>0)
                        {
                            var warningMsg="";
                            for (var i=0;i<warning.length;i++)
                            {
                                warningMsg+=warning[i]+"。";
                            }
                            showMsgBox("合区已完成.但有以下不影响开启服务器错误:\r\n"+warningMsg,"warning");
                        }else{
                            showMsgBox("合区已完成","success");
                        }
                    }
                }
            },
            error:function (msg) {
                $("#msgBox").removeClass("alert-info");
                $("#msgBox").addClass("alert-error");
                $("#msgBox").text(msg);

                $("#btnSubmit").attr("disabled",false);
                $("#btnSubmit").text("确认合区");
                alert("请求失败"+msg.code);
            }
        });
    }else{

    }

}