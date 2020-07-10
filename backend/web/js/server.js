function getDist() {
    var gameId=$("#server_game").val();
    getDistributor("#server_distributor",true,gameId,null,"../");
}
function getServers() {
    var gameId=$("#server_game").val();
    getDistributor("#server_distributor",true,gameId,null,"../");
}