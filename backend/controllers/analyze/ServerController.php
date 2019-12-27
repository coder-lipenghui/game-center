<?php


namespace backend\controllers\analyze;


use backend\models\report\ModelLoginLog;
use backend\models\TabLogLogin;
use backend\models\TabServers;
use yii\web\Controller;

class ServerController extends Controller
{
    public function actionIndex()
    {
        $gameId=1;
        $distributorId=1;
        $serverId=1;

        //
        $servers=TabServers::find()->where(['gameId'=>$gameId,'distributorId'=>$distributorId])->asArray()->all();
        $return=[];
        if (!empty($servers))
        {
            for ($i=0;$i<count($servers);$i++)
            {
                ModelLoginLog::TabSuffix(3,7);
                $login=new ModelLoginLog();
            }
        }
        //区服ID
        //实时在线-异步请求
        //今日登录，tab_log_login
        //付费账号数 tab_orders
        //付费角色数 tab_orders
        //arpu
        //当日充值  tab_orders
        //昨日充值  tab_orders
        //月累计充值 tab_orders
        //总充值    tab_orders


    }
}