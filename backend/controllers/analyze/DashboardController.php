<?php
namespace backend\controllers\analyze;

use backend\models\analyze\ModelDashBoard;
use backend\models\MyTabOrders;
use backend\models\MyTabPermission;
use backend\models\MyTabPlayers;
use yii\web\Controller;
use yii\web\Response;

class DashboardController extends Controller
{
    //游戏的仪表数据
    public function actionIndex()
    {
        return $this->render('dashboard',[

        ]);
    }
    public function actionGetDashboardInfo()
    {
        $request=\Yii::$app->request;
        $gameId=$request->get('gameId');

        $games=MyTabPermission::getGames();
        $data=[];
        for ($i=0;$i<count($games);$i++)
        {
            $gameId=$games[$i]['id'];
            $gameName=$games[$i]['name'];
            $result=[
                'gameId'=>$gameId,
                'gameName'=>$gameName,
                'totalRevenue'=>0,
                'totalUser'=>0,
                'totalDevice'=>0,
                'totalPayingUser'=>0,
                'totalArpu'=>0,
                'totalArppu'=>0,

                'last7dayLoginUser'=>0,
                'last30dayLoginUser'=>0,

                'todayRevenue'=>0,
                'todayLoginUser'=>0,
                'todayRegDevice'=>0,
                'todayRegUser'=>0,
                'todayPayingUser'=>0,

                'yesterdayRevenue'=>0,
                'yesterdayArpu'=>0,
                'yesterdayArppu'=>0,
                'yesterdayTodayLoginUser'=>0,
                'yesterdayTodayRegDevice'=>0,
                'yesterdayTodayRegUser'=>0,
            ];
            if ($gameId)
            {
                \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
                $result=[
                    'gameId'=>$gameId,
                    'gameName'=>$gameName,
                    'totalRevenue'=>$this->actionTotalRevenue($gameId),
                    'totalUser'=>$this->actionTotalUser($gameId),
                    'totalDevice'=>$this->actionTotalDevice($gameId),
                    'totalPayingUser'=>$this->actionTotalPayingUser($gameId),

                    'last7dayLoginUser'=>$this->actionLast7dayLoginUserCount($gameId),
                    'last30dayLoginUser'=>$this->actionLast30dayLoginUserCount($gameId),

                    'todayRevenue'=>$this->actionTodayRevenue($gameId),
                    'todayLoginUser'=>$this->actionTodayLoginUser($gameId),
                    'todayRegDevice'=>$this->actionTodayRegDevice($gameId),
                    'todayRegUser'=>$this->actionTodayRegUser($gameId),
                    'todayPayingUser'=>$this->actionTodayPayingUser($gameId),

                    'yesterdayRevenue'=>$this->actionYesterdayRevenue($gameId),
                    'yesterdayLoginUser'=>$this->actionYesterdayLoginUser($gameId),
                    'yesterdayRegDevice'=>$this->actionYesterdayRegDevice($gameId),
                    'yesterdayRegUser'=>$this->actionYesterdayRegUser($gameId),

                ];
                $data[]=$result;
            }
        }
        $total=[
            'gameId'=>0,
            'gameName'=>'汇总',
            'totalRevenue'=>array_sum(array_column($data,'totalRevenue')),
            'totalUser'=>array_sum(array_column($data,'totalUser')),
            'totalDevice'=>array_sum(array_column($data,'totalDevice')),
            'totalPayingUser'=>array_sum(array_column($data,'totalPayingUser')),
            'totalArpu'=>array_sum(array_column($data,'totalArpu')),
            'totalArppu'=>array_sum(array_column($data,'totalArppu')),
            'last7dayLoginUser'=>array_sum(array_column($data,'last7dayLoginUser')),
            'last30dayLoginUser'=>array_sum(array_column($data,'last30dayLoginUser')),
            'todayRevenue'=>array_sum(array_column($data,'todayRevenue')),
            'todayLoginUser'=>array_sum(array_column($data,'todayLoginUser')),
            'todayRegDevice'=>array_sum(array_column($data,'todayRegDevice')),
            'todayRegUser'=>array_sum(array_column($data,'todayRegUser')),
            'todayPayingUser'=>array_sum(array_column($data,'todayPayingUser')),
            'yesterdayRevenue'=>array_sum(array_column($data,'yesterdayRevenue')),
            'yesterdayArpu'=>array_sum(array_column($data,'yesterdayArpu')),
            'yesterdayArppu'=>array_sum(array_column($data,'yesterdayArppu')),
            'yesterdayTodayLoginUser'=>array_sum(array_column($data,'yesterdayTodayLoginUser')),
            'yesterdayTodayRegDevice'=>array_sum(array_column($data,'yesterdayTodayRegDevice')),
            'yesterdayTodayRegUser'=>array_sum(array_column($data,'yesterdayTodayRegUser'))
        ];
        $data[]=$total;
        return $data;
    }
    //--------total
    public function actionTotalUser($gameId)
    {
        return MyTabPlayers::getUserTotal($gameId);
    }
    public function actionTotalDevice($gameId)
    {
        return MyTabPlayers::getDeviceTotal($gameId);
    }
    public function actionTotalRevenue($gameId)
    {
        return MyTabOrders::getTotalRevenue($gameId);
    }
    public function actionTotalPayingUser($gameId)
    {
        return MyTabOrders::getTotalPayingUser($gameId);
    }

    //--------today
    public function actionTodayLoginUser($gameId)
    {
        $dashboard=new ModelDashBoard();
        return $dashboard->getTodayLoginUserNumber($gameId);
    }
    public function actionTodayPayingUser($gameId)
    {
        return MyTabOrders::getTodayPayingUser($gameId);
    }

    public function actionTodayLoginDevice($gameId)
    {

    }
    public function actionTodayRevenue($gameId)
    {
        return MyTabOrders::getTodayRevenue($gameId);
    }
    public function actionTodayRegUser($gameId)
    {
        return MyTabPlayers::getTodayRegister($gameId);
    }
    //--------yesterday
    public function actionTodayRegDevice($gameId)
    {
        return MyTabPlayers::getTodayRegisterDevice($gameId);
    }

//    public function actionTodayArpu($gameId)
//    {
//        $dashboard=new ModelDashBoard();
//        return $dashboard->getTodayArpu($gameId);
//    }
//    public function actionTodayArppu($gameId)
//    {
//        $dashboard=new ModelDashBoard();
//        return $dashboard->getTodayArppu($gameId);
//    }

    public function actionYesterdayRevenue($gameId)
    {
        return MyTabOrders::getYesterdayRevenue($gameId);
    }
    public function actionYesterdayLoginUser($gameId)
    {
        return MyTabPlayers::getYesterdayRegister($gameId);
    }
    public function actionYesterdayRegUser($gameId)
    {
        return MyTabPlayers::getYesterdayRegister($gameId);
    }
    public function actionYesterdayRegDevice($gameId)
    {
        return MyTabPlayers::getYesterdayRegisterDevice($gameId);
    }

    //--------Last 7 day info group by day


    //-------Last 30 day info group by day
    public function actionLast30dayRegUser($gameId)
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        return MyTabPlayers::getLast30RegUser($gameId);
    }

    public function actionLast30dayRegDevice($gameId)
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        return MyTabPlayers::getLast30RegDevice($gameId);
    }

    public function actionLast30dayRevenue($gameId)
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        return MyTabOrders::getLast30Revenue($gameId);
    }

    public function actionLast30dayArpu($gameId)
    {

    }

    public function actionLast30dayArppu($gameId)
    {

    }

    public function actionLast30dayPayingUser($gameId)
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        return MyTabOrders::getLast30PayingUser($gameId);
    }

    //count last N day info
    public function actionLast7dayLoginUserCount($gameId)
    {
        $dashboard=new ModelDashBoard();
        return $dashboard->getLast7dayLoginUserNumber($gameId);
    }
    public function actionLast30dayLoginUserCount($gameId)
    {
        \Yii::$app->response->format=Response::FORMAT_JSON;
        $dashboard=new ModelDashBoard();
        return $dashboard->getLast30dayLoginUserNumber($gameId);
    }

}