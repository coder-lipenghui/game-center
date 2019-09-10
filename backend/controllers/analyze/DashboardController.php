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
        $todayLoginUserNumber=$dashboard->getTodayLoginUserNumber();
        $todayArpu=$dashboard->getTodayArpu();
        $todayArppu=$dashboard->getTodayArppu();

        $last7dayLoginUserNumber=$dashboard->getLast7dayLoginUserNumber();
        $last30dayLoginUserNumber=$dashboard->getLast30dayLoginUserNumber();
//        $last7dayLoginDeviceNumber=$dashboard->getLast7dayLoginUserNumber();
//        $last30dayLoginDeviceNumber=$dashboard->getLast30dayLoginUserNumber();

        $totalToday=MyTabOrders::getTodayAmount();                          //今日总金额
        $totalYesterday=MyTabOrders::getYesterdayAmount();                  //昨日充值金额
        $totalTodayRegDevice=MyTabPlayers::getTodayRegisterDevice();        //今日注册设备数
        $totalYesterdayRegDevice=MyTabPlayers::getYesterdayRegisterDevice();//昨日注册设备数
        $todayRegister=MyTabPlayers::getTodayRegister();                    //今日注册用户数
        $yesterdayRegister=MyTabPlayers::getYesterdayRegister();            //昨日注册用户数

        $last30RegUser=MyTabPlayers::getLast30RegUser();                    //guoqu
        $last30RegDevice=MyTabPlayers::getLast30RegDevice();
        $last30Amount=MyTabOrders::getLast30Amount();
        $last30PayingUser=MyTabOrders::getLast30PayingUser();

        $userTotal=MyTabPlayers::getUserTotal();
        $deviceTotal=MyTabPlayers::getDeviceTotal();
        $payingUserTotal=MyTabOrders::getTotalPayingUser();
        $amountTotal=MyTabOrders::getTotalAmount();



//        $totalMonth=MyTabOrders::currentMonthAmount();//本月充值金额
//        $todayOpen=MyTabServers::todayOpen();//今日开服数量
//        $amountGroupByDistributor=MyTabOrders::amountGroupByDistributor();//各渠道充值金额
//        $userGroupByDistributor=MyTabPlayers::numberGroupByDistributor();//各渠道用户数量

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

            'userTotal'=>$userTotal,
            'deviceTotal'=>$deviceTotal,
            'payingUserTotal'=>$payingUserTotal,
            'amountTotal'=>$amountTotal,

            'last7dayLoginUserNumber'=>$last7dayLoginUserNumber,
            'last30dayLoginUserNumber'=>$last30dayLoginUserNumber,
            'todayLoginUserNumber'=>$todayLoginUserNumber,
//            'last7dayLoginDeviceNumber'=>$last7dayLoginDeviceNumber,
//            'last30dayLoginDeviceNumber'=>$last30dayLoginDeviceNumber,
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