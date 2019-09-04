<?php
namespace backend\controllers\analyze;

use backend\models\analyze\ModelDashBoard;
use backend\models\MyTabOrders;
use backend\models\MyTabPlayers;
use backend\models\MyTabServers;
use yii\web\Controller;

class DashboardController extends Controller
{
    //游戏的仪表数据
    public function actionIndex()
    {

        $dashboard=new ModelDashBoard();
        $todayArpu=$dashboard->arpuByDay();
        $todayArppu=$dashboard->arppuByDay();

        $totalToday=MyTabOrders::todayAmount();//今日总金额
        $totalYesterday=MyTabOrders::yesterdayAmount();//昨日充值金额
        $totalTodayRegDevice=MyTabPlayers::todayRegisterDevice();//今日注册设备数
        $totalYesterdayRegDevice=MyTabPlayers::yesterdayRegisterDevice();//昨日注册设备数
        $todayRegister=MyTabPlayers::todayRegister();//今日注册用户数
        $yesterdayRegister=MyTabPlayers::yesterdayRegister();//昨日注册用户数

//        $totalMonth=MyTabOrders::currentMonthAmount();//本月充值金额
//        $todayOpen=MyTabServers::todayOpen();//今日开服数量
//        $amountGroupByDistributor=MyTabOrders::amountGroupByDistributor();//各渠道充值金额
//        $userGroupByDistributor=MyTabPlayers::numberGroupByDistributor();//各渠道用户数量

        $last30RegUser=MyTabPlayers::getLast30RegUser();
        $last30RegDevice=MyTabPlayers::getLast30RegDevice();
        $last30Amount=MyTabOrders::getLast30Amount();
        $last30PayingUser=MyTabOrders::getLast30PayingUser();

        return $this->render('dashboard',[

            'totalToday'=>$totalToday,
            'totalYesterday'=>$totalYesterday,

            'totalTodayRegDevice'=>$totalTodayRegDevice,
            'totalYesterdayRegDevice'=>$totalYesterdayRegDevice,

            'todayRegister'=>$todayRegister,
            'yesterdayRegister'=>$yesterdayRegister,

            'todayArpu'=>$todayArpu,
            'todayArppu'=>$todayArppu,

            'last30RegUser'=>$last30RegUser,
            'last30RegDevice'=>$last30RegDevice,
            'last30Amount'=>$last30Amount,
            'last30PayingUser'=>$last30PayingUser,

//            'totalMonth'=>$totalMonth,
//            'todayOpen'=>$todayOpen,
//            'amountGroupByDistributor'=>$amountGroupByDistributor,
//            'userGroupByDistributor'=>$userGroupByDistributor,
        ]);
    }
    public function actionLast30RegDevice()
    {
        $deviceNumber=MyTabPlayers::getRegDeviceByDayNum();
    }
    public function actionLast30RegAccount()
    {
        $userNumber=MyTabPlayers::getRegNumByDayNum();
    }
    public function actionLast30Amount()
    {
        $amountByDayNum=MyTabOrders::getLast30Amount();
    }
    public function actionLast30Arpu()
    {

    }
    public function actionLast30Arppu()
    {

    }
    public function actionLast30Login()
    {

    }
    public function actionLast30PayingUser()
    {
        $payingUserNum=MyTabOrders::getLast30PayingUser();
    }
}