<?php
namespace backend\controllers\analyze;
use backend\models\analyze\ModelServerData;
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

    }
    /**
     * 留存数据
     * 1.单区开区时间的留存数据
     * 2.单区某天的留存数据
     */
    public function actionGetRetainData()
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $retain=new ModelServerData();
        return $retain->getRetain();
    }

    /**
     * 付费数据
     * 1.
     */
    public function actionGetPayData()
    {
        $gameId=1;
        $distributorId=1;
        $randomNum=rand(20,30);
        $servers=TabServers::find()->select(['id','openDateTime'])->orderBy('openDateTime')->orderBy('openDateTime DESC')->asArray()->all();

        for ($i=0;$i<count($servers);$i++)
        {
            $serverId=$servers[$i]['id'];
            $openDate=strtotime($servers[$i]['openDateTime']);
//            $randomServer=random_int(0,count($servers));
            //模拟开区前30天新增账户
            $randomOpenDay=rand(0,30);//开区第几天
            $randomAccount=rand(0,200);//新增用户数
            for ($j=0;$j<$randomAccount;$j++)
            {
                $account=new ModelRoleLog();
                $account::TabSuffix($gameId,$distributorId);
                $accountId=md5(time().rand(1,1000)."-");
                $account->distributionUserId=$accountId;
                $account->account=$accountId;
                $account->gameId=$gameId;
                $account->serverId=$serverId;
                $account->distributionId=2;
                $roleId=rand(10000000,99999999);
                $account->roleId=$roleId."";
                $account->roleName=$accountId;
                $account->createTime=$openDate;
//                exit("区".$serverId ." ".$servers[$i]['openDateTime']." ".date('Y-m-d',$openDate));
                $account->logTime=$openDate+($randomOpenDay*24*60*60);
                if($account->save())
                {
                    //模拟登录日志
                    $randomLoginNum=rand(0,5);//登录次数
                    for ($k=0;$k<$randomLoginNum;$k++)
                    {
                        $randomOpenDay=rand(0,30);
                        $loginLog=new ModelLoginLog();
                        $loginLog::TabSuffix($gameId,$distributorId);
                        $loginLog->account=$accountId;
                        $loginLog->distributionUserId=$accountId;
                        $loginLog->gameId=$gameId;
                        $loginLog->distributionId=$distributorId;
                        $loginLog->serverId=$serverId;
                        $loginLog->roleName=$accountId;
                        $loginLog->roleId=$roleId."";
                        $loginLog->roleLevel=rand(85,90);
                        $loginLog->deviceId="862497046364746";
                        $loginLog->deviceVender="samsung";
                        $loginLog->deviceOs="10";
                        $loginLog->logTime=$openDate+($randomOpenDay*24*60*60);
                        if(!$loginLog->save())
                        {
                            exit(json_encode($loginLog->getErrors(),JSON_UNESCAPED_UNICODE));
                        }
                    }
                }else
                {
                    exit(json_encode($account->getErrors(),JSON_UNESCAPED_UNICODE));
                }
            }


        }





    }
}