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