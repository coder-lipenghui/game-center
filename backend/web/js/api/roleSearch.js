
$(document).ready(function(){
    $('#applyForVcion').on('show.bs.modal', function (e) {

    })
})
function changeGame(sender) {
    getDistributor("#platform",true,$("#games").val(),null,"../");
};
function changePt(sender) {
    var gid=$("#games").val();
    var pid=$("#platform").val();
    getServers("#servers",true, gid, pid,null,"../");
}
function changeServer(sender) {
    // alert($("#servers").val());
}
function changeSupportGame(sender,target) {
    getDistributor(target,true,$(sender).val(),null,"../");
};
function changeSupportDistributor(sender,target1,target2) {
    var gid=$(target1).val();
    var did=$(sender).val();
    getServers(target2,true, gid, did,null,"../");
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
function changeSupportType() {
    var type=$("#supportType").val();
    if (type == 0) {
        $("#roleName").removeClass("hidden");
        $("#roleAccount").addClass("hidden");
    }else{
        $("#roleAccount").removeClass("hidden");
        $("#roleName").addClass("hidden");
    }
}
function getPlayerName() {
    $("#cmdkick-playername").val($("#roleinfo-chrname").val());
}
function submitKick()
{
    var form=$("#kickForm");
    $.ajax({
        url:"../cmd/kick",
        type: "get",
        dataType: "json",
        success:function (data) {
            alert(data.code+data.msg);
        },
        error:function (msg) {
            alert("请求失败"+msg.code);
        }
    });
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
                //先不考虑效率问题
                for (var i=0;i<Object.keys(data.items).length;i++)
                {
                    var roleJson=data.items[i];
                    $("#roleList tbody").append(
                        "<tr>" +
                        "<td>" +
                        "<span class='roleLabel' seedId='"+roleJson.seedId+"' onclick='showRoleInfo(this)'>"+
                        roleJson.chrname+
                        "</span>"+
                        "<small>(lv:"+roleJson.lv+")</small>"+
                        "</td>" +
                        "</tr>>");
                    var show=false;
                    if(i==0)
                    {
                        show=true;
                    }
                    buildAttribute(roleJson,show);
                    buildItemBag(roleJson.seedId,roleJson.item_bag);
                    //buildItemBag(roleJson.item_depot1);
                    //buildItemBag(roleJson.item_depot2);
                }
            }
        },
        error:function (msg) {
            alert("请求失败"+msg);
        }
    });
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
        $("#role_attr_"+data.seedId+" ."+key).text(data[key]);
    }
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
function showRoleInfo(sender) {
    var seedId=$(sender).attr("seedId");
    $(".roleLabel").removeClass("glyphicon glyphicon-menu-right");
    $(sender).addClass("glyphicon glyphicon-menu-right");

    //显示对应角色的背包信息
    $(".roleWears").addClass("hidden");
    $("#role_wears_"+seedId).removeClass("hidden");

    //显示对应角色的舒心信息
    $(".roleAttribute").addClass("hidden");
    $("#role_attr_"+seedId).removeClass("hidden");
}