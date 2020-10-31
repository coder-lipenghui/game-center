
$(document).ready(function(){
    $('#applyForVcion').on('show.bs.modal', function (e) {

    })
})
function changeGame(sender) {
    $("#supportGames").val($("#games").val());
    getDistributor("#platform",true,$("#games").val(),null,"../");
    getDistributor("#supportDistributors",true,$("#games").val(),null,"../");
    getItemsByGame("selectItems",$("#games").val(),"../");
    getProducts();
}
function getProducts() {
    var gameId=$("#games").val();
    var documentid="#txtProducts";
    $.ajax({
        type: 'get',
        data: {
            gameId:gameId
        },
        dataType: "json",
        url: "../../support/product",
        async: true,
        success: function(data) {
            if (data)
            {
                $.each(data, function(i) {
                    $("<option value='" + data[i].id + "'>" + data[i].name + "</option>").appendTo(documentid);
                });
            }else{
                console.log("数据获取异常");
            }
        },
        error: function(data) {
            console.log("获取数据失败");
        }
    });
}
function changePt(sender) {
    var gid=$("#games").val();
    var pid=$("#platform").val();
    getServers("#servers",true, gid, pid,null,"../");
    getServers("#supportServers",true, gid, pid,null,"../");
}
function changeServer(sender) {
    var gameId=$("#games").val();
    var serverId=$("#servers").val();

    $("#supportGames").val(gameId);
    $("#supportDistributors").val($("#platform").val());
    $("#supportServers").val(serverId);

    $("#unvoiceGameId").val(gameId);
    $("#unvoiceServerId").val(serverId);

    $("#allowLoginGameId").val(gameId);
    $("#allowLoginServerId").val(serverId);

    $("#denyLoginGameId").val(gameId);
    $("#denyLoginServerId").val(serverId);
}
function changeSupportGame(sender,target) {
    getDistributor(target,true,$(sender).val(),null,"../");
};
function changeSupportDistributor(sender,target1,target2) {
    var gid=$(target1).val();
    var did=$(sender).val();
    getServers(target2,true, gid, did,null,"../");
}
function removeItem(target)
{
    $(target).parent().parent().remove();
    buildSupporItemInfo();
}
function buildSupporItemInfo()
{
    var supporItems=[];
    $(".supporItemInfo").each(function(){
        supporItems.push($(this).val());
    });
    $("#supporItems").val(supporItems.join(","));
}
function addItem() {
    var itemId=$("#selectItems").val();
    var itemName=$("#selectItems").find(":selected").text();
    var num=$("#itemNum").val();

    var bind=0;
    if ($('#ckBind').is(':checked'))
    {
        bind=1;
    }
    var itemInfo=itemId+","+num+","+bind;
    $("#tabSupporItems tr").eq(0).after("<tr><td class='supporItemName'><input class='supporItemInfo' type='hidden' id='supporItemId' value='"+itemInfo+"'/>"+itemName+"</td><td class='supporItemNum'>"+num+"</td><td class='supporItemBind'>"+bind+"</td><td><div class='btn btn-small btn-danger' onclick='removeItem(this)'>移除</div></td></tr>")
    $("#selectItem").addClass("hidden")
    buildSupporItemInfo();
}
function handleAddItem()
{
    $("#selectItem").removeClass("hidden");
}
/**
 * command操作
 */
function doCmdSubmit(form,url,modal) {
    var form=$("#"+form);
    var formData = form.serialize();
    $.ajax({
        type: 'get',
        data: formData,
        dataType: "json",
        url: url,
        async: true,
        success: function(data) {
            if (data.code==1 || data.code=="1")
            {
                alert("禁言成功");
                $("#"+modal).modal("toggle");
            }else{
                alert("禁言失败");
            }
        },
        error: function(data) {
            alert('操作失败');
        }
    });
}
/**禁言*/
function submitUnvoice() {
    doCmdSubmit("unvoiceForm","../cmd/unvoice","unvoice");
}
/**扶持*/
function createSupport() {
    doCmdSubmit("createSupportForm","../../support/create","applyForVcion")
}
/**踢人*/
function submitKick()
{
    doCmdSubmit("kickForm","../cmd/kick","")
}
/**封角色*/
function denyCharacter() {
    doCmdSubmit("denyLoginForm","../cmd/deny-login","denyLogin")
}
/**解封角色*/
function allowCharacter() {
    doCmdSubmit("allowLoginForm","../cmd/allow-login","allowLogin")
}
function changeSupportType() {
    var type=$("#supportType").val();
    $("#number").addClass("hidden");
    $("#trSupporItems").addClass("hidden");
    $("#products").addClass("hidden");
    $("#reason").addClass("hidden");
    if (type==0 || type==1)
    {
        $("#reason").removeClass("hidden");
        $("#number").removeClass("hidden");
    }
    if (type==2)
    {
        $("#reason").removeClass("hidden");
        $("#products").removeClass("hidden");
        $("#txtNumber").val(1);
    }
    if (type==3)
    {
        $("#reason").removeClass("hidden");
        $("#trSupporItems").removeClass("hidden");
        $("#txtNumber").val(1);
    }
}
function getPlayerName() {
    $("#cmdkick-playername").val($("#roleinfo-chrname").val());
}

function doAjaxSubmit() {
    var form=$("#searchForm");
    var formData = form.serialize();
    $.ajax({
        url:"index",
        type: "get",
        dataType: "json",
        data:formData,
        success:function (data) {
            $("#roleList tbody").empty();

            $("#roleBag").empty();
            $("#roleDepot").empty();
            $("#roleWears").empty();

            $("#baseAttribute").empty();

            if (data && data.items)
            {
                for (var i=0;i<Object.keys(data.items).length;i++)
                {
                    var roleJson=data.items[i];
                    $("#roleList tbody").append(
                        "<tr>" +
                        "<td>" +
                        "<a class='btn btn-default roleLabel' href='#' seedId='"+roleJson.seedId+"' onclick='showRoleInfo(this)'>"+
                        roleJson.chrname+"(lv:"+roleJson.lv+")"+
                        "</a>"+
                        "</td>" +
                        "</tr>>");
                    var show=false;
                    if(i==0)
                    {
                        show=true;
                    }
                    buildAttribute(roleJson,show);
                    //buildItemBag(roleJson.seedId,roleJson.item_bag);
                    //buildItemBag(roleJson.item_depot1);
                    //buildItemBag(roleJson.item_depot2);
                }
            }
        },
        error:function (msg) {
            console.log("请求失败"+msg);
        }
    });
}

/**
 *
 * @param sender
 */
function showRoleInfo(sender) {
    var seedId=$(sender).attr("seedId");
    $(".roleLabel").removeClass("glyphicon glyphicon-menu-right");
    $(sender).addClass("glyphicon glyphicon-menu-right");

    //显示对应角色的背包信息
    // $(".roleWears").addClass("hidden");
    // $("#role_wears_"+seedId).removeClass("hidden");

    //显示对应角色的信息
    var account=$("#role_attr_"+seedId+" .account").text();
    var seedName=$("#role_attr_"+seedId+" .seedname").text();
    var roleName=$("#role_attr_"+seedId+" .chrname").text();
    $(".roleAttribute").addClass("hidden");
    $("#role_attr_"+seedId).removeClass("hidden");

    $("#txtRoleAccount").val(account);
    $("#txtRoleId").val(seedName);
    $("#txtRoleName").val(roleName);

    $("#unvoiceRoleName").val(roleName);
    $("#allowLoginRoleName").val(roleName);
    $("#denyLoginRoleName").val(roleName);
    $("#hiddenAccount").val(account);
    $("#hiddenChrname").val(roleName);
    $("#hiddenRoleId").val(seedName);
}

/**
 * 构建玩家属性
 * @param data
 */
function buildAttribute(data,show) {
    var roleAttr=$("#cloneAttrTarget").clone().attr("id","role_attr_"+data.seedId);

    $("#baseAttribute").append(roleAttr);
    if(show==false)
    {
        roleAttr.addClass("hidden");
    }
    for (var key in data) {
        var val=data[key];
        switch (key)
        {
            case "deleted":
                var style=val==1?"label label-danger":"label label-success";
                var text=val==1?"已删除":"正常";
                var btnRecover=val==1?"<div class='btn btn-success btn-xs' id='btnRecoverRole' onclick='recoverRole()'>恢复</div>":"";
                val="<span id='roleStatus' class=\""+style+"\">"+text+"</span>"+btnRecover;
                $("#recoverRole").show();
                break;
        }
        $("#role_attr_"+data.seedId+" ."+key).html(val);
    }
}
/**
 * 角色、物品、变量标签点击操作
 * @param sender
 * @param id
 */
function handlerTabSelected(sender,id) {
    $("#tabRoleInfo li").removeClass("active");
    $(sender).parent().addClass("active");
    $(".roleTable").addClass("hidden");
    $("#"+id).removeClass("hidden");
}

/**
 * 穿戴、背包、仓库位置切换
 * @param sender
 * @param id
 */
function handlerTabPosSelected(sender,id) {
    $("#tabPosition li").removeClass("active");
    $(sender).parent().addClass("active");
    $(".itemTable").addClass("hidden");
    $("#"+id).removeClass("hidden");
}


/**
 * 构建玩家穿戴装备物品
 * @param data
 */
function buildWearItem(seedid,items) {
    // alert(items);
    var wears=$("#cloneWearsTarget").clone().attr("id","role_wears_"+seedid);
    $("#roleWears").append(wears);
    wears.addClass("hidden");
    for (var i=0;i<items.length;i++)
    {
        var data=items[i];
        // alert(data['type']['name']);
        var td=$("#role_wears_"+seedid+" .pos_"+data['pos']);
        td.append("<img src='../../icon/"+data['type']['icon_id']+".png' title='"+data['type']['name']+"' class='img-thumbnail'/>");
    }
}

/**
 * 构建背包物品
 * @param seedid 唯一标示
 * @param data 物品信息json
 */
function buildItemBag(seedid,data) {
    var item_bg=$("#cloneBagTarget").clone().attr("id","role_bag_"+seedid);

    $("#roleBag").append(item_bg);

    var rect=15;
    var wears=new Array();
    var bag=new Array();

    for (var k=0;k<data.length;k++){
        if(data[k]['pos'] && data[k]['pos']<0)
        {
            wears.push(data[k]);
        }else{
           bag.push(data[k]);
        }
    }
    for (var i=0;i<rect;i++)
    {
        var tr=item_bg.append("<tr/>");
        for(var j=0;j<rect;j++)
        {
            var id=i*rect+j;
            if(bag && bag[id])
            {
                tr.append("<td width='55' height='55'><img src='../../icon/"+bag[id]['type']['icon_id']+".png' alt='"+bag[id]['type']['name']+"' title='"+bag[id]['type']['name']+"' class='img-thumbnail'/></td>");
            }
        }
    }
    if (wears.length>0)
    {
        buildWearItem(seedid,wears);
    }
}
function recoverRole()
{
    var gameId=$("#games").val();
    var cdistributorId=$("#platform").val();
    var serverId=$("#servers").val();
    var chrname=$("#hiddenChrname").val();
    var account=$("#hiddenAccount").val();
    $.ajax({
        url:"recover",
        type: "post",
        dataType: "json",
        data:{
            'gameId':gameId,
            'distributorId':cdistributorId,
            'serverId':serverId,
            'account':account,
            'chrname':chrname
        },
        success:function (data) {
            if (data['code']==1)
            {
                $("#btnRecoverRole").hide();
                $("#roleStatus").removeClass("label-danger");
                $("#roleStatus").addClass("label-success");
                $("#roleStatus").text("正常");
                alert("已恢复");
            }else{
                alert("恢复异常:"+data['msg']);
            }
        },
        error:function (msg) {
            alert("请求失败"+msg);
        }
    });
}
function prohibitLogin(type,account) {
     $.ajax({
        url:"../../blacklist/",
        type: "post",
        dataType: "json",
        data:{
            type:type,
            'account':account
        },
        success:function (data) {

        },
        error:function (msg) {
            alert("请求失败"+msg);
        }
     });
}