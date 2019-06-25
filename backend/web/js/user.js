function getDistributorsByGameId() {
    var url="";
    var games=[];
    $("input[name='MyUserModel[games][]']").each(function() {
        if (this.checked) {
            var id=$(this).val();
            games.push(id)
        }
    });
    $("#distributors").empty();
    $.ajax({
        type: 'get',
        data: {
            gameId:games,
        },
        async:false,
        dataType: "json",
        url: (url==null?"":url)+"../permission/get-all-distribution",
        success: function(data) {
            buildDistributions(data)
        },
        error: function(data) {
            alert('获取数据失败');
        }
    });
}
function buildDistributions(data,selectAll) {
    $("#distributions").empty();
    //name id
    var distributors=[];
    $.each(data, function(i) {
        distributors[data[i].distributorId]=data[i].name;
        var icon="android.png";
        // var platform="安卓";
        if (data[i].platform==2)
        {
            icon="ios.png";
            // platform="IOS";
        }
        $('<label>' +
            '<input type="checkbox" name="MyUserModel[distributions][]" value="'+data[i].id +'"/>' +
            '<img src="../'+icon+'" width="14" height="14" style="padding-bottom: 2px"/>'+
            ''+data[i].name+
            '</label>').appendTo("#distributions");
    });
    if (selectAll)
    {
        selectDistributions(true);
    }
}
function onGamesClick() {
    var selected=$("#selectAllGame").is(":checked");
    selectGames(selected);
}
function selectGames(checked) {

    $("input[name='MyUserModel[games][]']").each(
        function () {
            if (checked)
            {
                $(this).attr('checked','checked');
            }else{
                $(this).removeAttr('checked');
            }

        }
    );
    if (checked)
    {
        getDistributorsByGameId();
    }
}
function onDistributionClick(){
    var selected=$("#selecteAllDistribution").is(":checked");
    selectDistributions(selected);
}
function selectDistributions(checked) {

    $("input[name='MyUserModel[distributions][]']").each(
        function () {
            if (checked)
            {
                $(this).attr('checked','checked');
            }else{
                $(this).removeAttr('checked');
            }
        }
    );
}