<?php
namespace backend\controllers;

use backend\models\MyTabOrders;
use backend\models\MyTabPlayers;
use backend\models\MyTabServers;
use backend\models\TabOrders;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],//@代表认证过的用户 ？未认证
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
//        $msg="";
//        $totalToday=MyTabOrders::todayAmount();
//        $totalMonth=MyTabOrders::currentMonthAmount();
//        $todayOpen=MyTabServers::todayOpen();
//        $todayRegister=MyTabPlayers::todayRegister();
//        $amountGroupByDistributor=MyTabOrders::amountGroupByDistributor();
//        $userGroupByDistributor=MyTabPlayers::numberGroupByDistributor();
        return $this->render('index',[
//            'totalToday'=>$totalToday,
//            'totalMonth'=>$totalMonth,
//            'todayOpen'=>$todayOpen,
//            'todayRegister'=>$todayRegister,
//            'amountGroupByDistributor'=>$amountGroupByDistributor,
//            'userGroupByDistributor'=>$userGroupByDistributor,
//            'msg'=>$msg,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
