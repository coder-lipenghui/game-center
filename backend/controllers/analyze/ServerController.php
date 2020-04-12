<?php
namespace backend\controllers\analyze;
use backend\models\analyze\ModelServerPayData;
use backend\models\analyze\ModelServerRetainData;
use backend\models\MyTabPermission;
use backend\models\report\ModelLoginLog;
use backend\models\report\ModelRoleLog;
use backend\models\TabLogLogin;
use backend\models\TabServers;
use yii\web\Controller;
use yii\web\Response;

/**
 * 区服数据分析：
 * 1.区服留存数据：总用户数 次/3/5/7/15/30日留存
 * 2.区服付费数据：总用户数 总付费 付费人数 arpu arppu
 * 3.
 * Class ServerController
 * @package backend\controllers\analyze
 */
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
    public function actionRetain()
    {
        //留存数据页面
        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();

        return $this->render('retain',[
            'games'=>$games
        ]);
    }
    public function actionPay()
    {
        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();

        return $this->render('pay',[
            'games'=>$games
        ]);
    }
    /**
     * 留存数据
     * 1.单区开区时间的留存数据
     * 2.单区某天的留存数据
     */
    public function actionGetRetainData()
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $retain=new ModelServerRetainData();
        return $retain->getRetain();
    }

    /**
     * 付费数据
     * 1.
     */
    public function actionGetPayData()
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $pay=new ModelServerPayData();
        return $pay->getPayData();
    }
}