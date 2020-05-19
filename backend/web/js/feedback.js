function handleChangeGame(sender) {
    var gameId=$("#feedback_game").val();
    console.log("当前选中的游戏ID:"+gameId);
    getDistributor("#feedback_dist",true,gameId,null,"../");
}

// function handleIndexChangeDistributor() {
//     var gameId=$("#noticeGames").val();
//     var distributorId=$("#noticeDistributors").val();
//     getDistribution("#noticeDistributions",gameId,distributorId,"../");
// }