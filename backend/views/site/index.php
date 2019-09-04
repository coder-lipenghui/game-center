<?php
use yii\helpers\Html;
use yii\widgets\menu;

?>
<?php

/* @var $this yii\web\View */
$this->title = '首页';
//public $secretKey="longcitywebonline12345678901234567890";
//public $ip="111.231.60.73";
//public $port="8310";
//$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//if (!$socket) {
//    exit(socket_last_error($socket));
//}
////        if (!socket_connect($socket, $this->ip, $this->port)) {
//if (!socket_connect($socket, "111.231.60.73", 8310)) {
//    exit(socket_last_error($socket));
//}
//$in = md5('kick wht'.'longcitywebonline12345678901234567890').'kick wht'.'\n';
//if (!socket_write($socket, $in, strlen($in))) {
//    exit(socket_last_error($socket));
//}
//exit(trim(socket_read($socket, 1024)));
//
//socket_close($socket);
$this->registerJsFile("@web/js/echarts.min.js",['position'=>\yii\web\View::POS_HEAD]);
?>
<div class="panel panel-default">
    <div class="panel-body">
        <b>快捷导航</b>
        <p>参数配置：渠道参数配置 </p>
        <p>玩家操作：日志信息 玩家明细</p>
        <p>数据分析：数据概况、</p>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-body">
        <h3>商务&市场合作</h3>
        <p><hr/></p>
        <div class="row">
            <div class="col-md-3">
                <b>商务合作</b>
                <p>联系人：杨先生</p>
                <p>电  话：16605110306</p>
                <p>Q   Q：3464285</p>
            </div>
            <div class="col-md-3">
                <p><b>市场合作</b></p>
                <p>联系人：赵先生</p>
                <p>电  话：16605110306</p>
                <p>Q   Q：3464285</p>
            </div>
            <div class="col-md-3">
                <p><b>技术支持</b></p>
                <p>联系人：李先生</p>
                <p>电  话：16605110306</p>
                <p>Q   Q：3464285</p>
            </div>
            <div class="col-md-3">
                <p><b>联系我们</b></p>
                <p>联系人：李先生</p>
                <p>电  话：16605110306</p>
                <p>Q   Q：3464285</p>
            </div>
        </div>
    </div>
</div>
