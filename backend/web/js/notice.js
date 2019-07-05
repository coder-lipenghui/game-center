function handleChangeGame(sender) {
    var gameId=$("#noticeGames").val();
    getDistributor("#noticeDistributors",true,gameId,null,"../");
}
function handleIndexChangeDistributor() {
    var gameId=$("#noticeGames").val();
    var distributorId=$("#noticeDistributors").val();
    getDistribution("#noticeDistributions",gameId,distributorId,"../");
}
function handleChangeDistributor() {
    var gameId=$("#noticeGames").val();
    var distributorId=$("#noticeDistributors").val();
    $("#noticeDistributions").empty();
    $.ajax({
        type: 'get',
        data: {
            gameId:gameId,
            distributorId:distributorId
        },
        dataType: "json",
        url: "../../permission/get-distribution",
        async: true,
        success: function(data) {
            $.each(data, function(i) {
                var platform="安卓";
                if (data[i].platform==2)
                {
                    platform="IOS";
                }
                $('<label><input type="checkbox" name="MyTabNotice[distributions][]" value="'+data[i].id+'"> '+data[i].name + '('+platform+')</label>').appendTo("#noticeDistributions");
                //$("<option value='" + data[i].id + "'>" + data[i].name + "("+platform+")</option>").appendTo("#noticeDistributions");
            });
            $("#noticeDistributions").selectpicker('refresh');
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}