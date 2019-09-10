function getDist() {
    var url="";
    var gid=$("#server_game").val();
    var did=$("#server_distributor").val();
    $.ajax({
        type: 'get',
        data: {
            gameId:gid,
            distributorId:did,
        },
        dataType: "json",
        url: (url==null?"":url)+"../permission/get-distribution",
        async: true,
        success: function(data) {
            $("#tabservers-distributions").empty();
            $("#server_distributor").empty();
            var distributors=[];
            $.each(data, function(i) {
                distributors[data[i].distributorId]=data[i].name;
                var icon="glyphicon glyphicon-phone";
                var platform="安卓";
                if (data[i].platform==2)
                {
                    icon="glyphicon glyphicon-apple";
                    platform="IOS";
                }
                $('<label>' +
                    '<input type="checkbox" name="TabServers[distributions][]" value="'+data[i].id +'">' +
                    '<span class="'+icon+'"></span>'+
                    ''+data[i].name+'-<small>['+platform+']</small>' +
                    '<span>&nbsp;&nbsp;</span>'+
                    '</label>').appendTo("#tabservers-distributions");
            });
            // var dropDownList=$("#server_distributor").parent();
            //TODO 渠道商下拉列表的选中暂时未完成
            // $("ul.dropdown-menu").empty();
            // for (var i=0;i<distributors.length;i++)
            // {
            //     if (distributors[i])
            //     {
            //         var distributorName= distributors[i];
            //         $("<option value='"+i+"'>"+distributorName+"</option>").appendTo("#server_distributor");
            //         var li='<li data-original-index="'+i+'">' +
            //             '<a tabindex="0" class="" data-tokens="null" role="option" aria-disabled="false" aria-selected="true">' +
            //             '<span class="text">'+distributorName+'</span>' +
            //             '<span class="glyphicon glyphicon-ok check-mark"></span>' +
            //             '</a>' +
            //             '</li>';
            //         $("ul.dropdown-menu").append(li);
            //     }
            // }
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}