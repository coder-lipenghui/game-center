function handleGameChange() {
    var gameId=$("#gameUpdateGames").val();
    getDistributor("#gameUpdateDistributions",true,gameId,null,"../");
}