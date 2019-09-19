<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-07
 * Time: 23:04
 */

namespace backend\controllers\center;

use backend\models\AutoCDKEYModel;
use backend\models\center\ActivateCdkey;
use backend\models\center\CreateOrder;
use backend\models\center\CreateOrderDebug;
use backend\models\center\EnterGame;
use backend\models\center\Login;
use backend\models\MyGameAssets;
use backend\models\MyGameUpdate;
use backend\models\MyTabNotice;
use backend\models\MyTabOrders;
use backend\models\MyTabServers;
use backend\models\report\ModelLevelLog;
use backend\models\report\ModelLoginLog;
use backend\models\report\ModelRoleLog;
use backend\models\report\ModelStartLog;
use backend\models\TabBlacklist;
use backend\models\TabCdkeyRecord;
use backend\models\TabCdkeyVariety;
use backend\models\TabDistribution;
use backend\models\TabGames;
use backend\models\TabOrders;
use backend\models\TabOrdersDebug;
use backend\models\TabPlayers;
use backend\models\TabServers;
use common\helps\CurlHttpClient;
use common\helps\LoggerHelper;
use yii\base\Exception;
use yii\web\Controller;
/**
 * 渠道登录、充值相关
 * 登录：
 *      1.参数验证->渠道登录接口验证->我方创建/拉去用户->黑名单->构建游戏返回值：用户、公告、区服。
 *      2.notify->游戏侧API验证
 * 充值：
 *      渠道订单验证->更新支付状态->记录到已支付表->发货
 * 其他：
 *      SDK接入相关工作请参考README.MD
 * @package backend\controllers\center
 */
class CenterController extends Controller
{
    //数据上报部分
    public static $REPORT_TYPE_SELECT_SERVER    =1; //选服时
    public static $REPORT_TYPE_ENTER_SERVER     =2; //服务器登录成功，尚未进入到游戏场景
    public static $REPORT_TYPE_CREATE_ROLE      =3; //创建角色
    public static $REPORT_TYPE_ROLE_UPDATE      =4; //角色发生变化，常规是等级变化
    public static $REPORT_TYPE_ENTER_GAME       =5; //进入到游戏场景
    public static $REPORT_TYPE_ENTER            =6; //启动游戏

    public static $CODE_SUCCESS                 =  1; //成功
    public static $ERROR_SYSTEM                 = -1; //系统错误
    public static $ERROR_PARAMS                 = -2; //参数错误
    public static $ERROR_GAME_NOT_FOUND         = -3; //游戏未找到
    public static $ERROR_DISTRIBUTOR_NOT_FOUND  = -4; //分销渠道未找到
    public static $ERROR_USER_VALIDATE_FAILED   = -5; //用户登录验证失败
    public static $ERROR_ORDER_VALIDATE_FAILED  = -6; //游戏订单验证直白
    public static $ERROR_USER_SAVE_FAILED       = -7; //用户信息保存失败
    public static $ERROR_IN_BLACKLIST           = -8; //禁止登录

    public static $ERROR_PAYMENT_PARAMS         = -1; //支付参数错误
    public static $ERROR_PAYMENT_VALIDATE_FAILED= -2; //支付订单验证失败

    public $enableCsrfValidation=false; //允许post访问

    /**支付成功返回信息，需要在派生类中重写*/
    protected $paymentSuccess="SUCCESS";

    /**支付验证失败信息,需要在派生类中重写*/
    protected $paymentValidateFailed="VALIDATE FAILED";

    /**订单号重复信息*/
    protected $paymentRepeatingOrder="ORDER REPEAT";

    /**订单金额不匹配*/
    protected $paymentAmountFailed="ORDER AMOUNT FAILED";

    /***/
    protected $paymentDeliverFailed="DELIVER FAILED";

    protected $paymentOrderNotFound="ORDER NOT FOUND";

    protected $paymentOrderStatusFailed="ORDER STATUS FAILED";

    /**
     * 供SDK调用的登录验证接口
     */
    public function actionLogin()
    {
        $data=[];
        $loginModel=new Login();
        $jsonData=file_get_contents("php://input");
        $requestData=json_decode($jsonData,true);
        $loginModel->load(['Login'=>$requestData]);
        if ($loginModel->validate())
        {
            $game=TabGames::findOne(['sku'=>$loginModel->sku]);
            if ($game===null)
            {
                $this->send(CenterController::$ERROR_GAME_NOT_FOUND,\Yii::t('app',"未知游戏"));
            }
            //登录权限检测
            $this->checkLoginPremission($requestData,$game);

            $distribution=TabDistribution::find()->where(['id'=>$loginModel->distributionId,'gameId'=>$game->id])->one();
            if ($distribution===null)
            {
                echo($distribution->id.$distribution->name.$game->id);
                $this->send(CenterController::$ERROR_DISTRIBUTOR_NOT_FOUND,\Yii::t('app',"分销渠道不存在"));
            }
            $cache=\Yii::$app->cache;
//            $cache->flush();//清理缓存
//            $cache->delete($tokenKey);//根据key清理缓存
            $tokenKey=md5($requestData['uid'].$requestData['distributionId'].$this->getClientIP().time());
            $token=$cache->get($tokenKey);
            if(empty($token) || $token===null)
            {
                $user=$this->loginValidate($requestData,$distribution);
                if (empty($user) || $user===null)
                {
                    $this->send(CenterController::$ERROR_USER_VALIDATE_FAILED,\Yii::t('app',"用户验证失败"));
                }
                $player=$this->savePlayer($user,$requestData,$distribution);
                if($player===null)
                {
                    $this->send(CenterController::$ERROR_USER_SAVE_FAILED,\Yii::t('app',"用户信息存储失败"));
                }
                $cache->set($tokenKey,
                    [
                        'gameId'=>$game->id,
                        'distributionId'=>$user['distributionId'],
                        'account'=>$player->account,
                    ],
                    600);
                $data['player']=[
                    'token'=>$tokenKey,
                    'uid'=>$player->distributionUserId,
                    'account'=>$player->account,
                ];
            }else{
                $data['player']=[
                    'token'=>$tokenKey,
                    'uid'=>$token['distributionUserId']
                ];
            }
            //TODO 构建公告信息 ###title|||content###title|||content
            $notice=MyTabNotice::searchGameNotice($game->id,$distribution->id);
            if (empty($notice))//默认构建一条公告
            {
                $notice="欢迎|||亲爱的玩家您好，欢迎来到《".$game->name."》。如果您在游戏内遇到问题，请先联系我们的客服 我们将尽快为您解决问题。";
            }
            $servers=MyTabServers::searchGameServers($game->id,$distribution->id);

            $data['serverInfo']=$servers;
            $data['anncInfo']=$notice;
        }else{
            $this->send(CenterController::$ERROR_PARAMS,\Yii::t('app',"参数错误"),$loginModel->getErrors());
        }
        $this->send(1,'success',$data);
    }
    /**
     * 支付回调接口
     *
     * 暂时不考虑使用【key：controller|model】的映射关系做动态model或动态controller进行登录、充值验证
     * 方便重写各个接口，常规情况下 各渠道只需要重写orderValidate方法
     *
     * 周期：回调接口访问->获取渠道信息->渠道订单验证->支付金额校验->更新支付状态->发货->更新发货状态
     * 备注：
     *   获取分销渠道信息的方式常规有两种
     *   1: payment-call-back/<distributionId> 后面的distributionId
     *   2: 通过我方订单号查找distributionId
     */
    public function actionPaymentCallback()
    {
        $distributionId=$this->getDistributionId();

        if ($distributionId!=null)
        {
            $distributionQuery=TabDistribution::find()->where(['id'=>$distributionId]);
            $distribution=$distributionQuery->one();

            $orderArray=$this->orderValidate($distribution);

            if ($orderArray!=null)
            {
                if ($distribution->isDebug==1)
                {
                    $order=TabOrdersDebug::find()->where(['orderId'=>$orderArray['orderId']])->one();
                }else{
                    $order=TabOrders::find()->where(['orderId'=>$orderArray['orderId']])->one();
                }
                if($order)
                {
                    //充值金额校验
                    if ($order->payAmount==$orderArray['payAmount'])
                    {
                        //更新支付状态
                        $order->setAttribute('distributionOrderId',$orderArray['distributionOrderId']);
                        $order->setAttribute('payStatus','1');
                        $order->setAttribute('payTime',$orderArray['payTime']);
                        try{
                            if($order->save())
                            {
                                //通知分销渠道充值成功
                                if (!$this->deliver($order['orderId'],$distribution))
                                {
                                    return $this->paymentDeliverFailed;
                                }
                                return $this->paymentSuccess;
                            }else{
                                $msg="支付状态更新失败";
                                \Yii::error($order->getErrors(),"order");
                                return $this->paymentOrderStatusFailed;
                            }
                        }catch (\yii\db\Exception $exception)
                        {
                            $msg="支付状态更新失败";
                            \Yii::error($msg,"order");
                            return "SYSTEM EXCEPTION";
                        }
                    }else{
                        $msg="支付金额不匹配";
                        \Yii::error($msg,"order");
                        return $this->paymentAmountFailed;
                    }
                }else{
                    $msg="订单不存在";
                    \Yii::error($msg,"order");
                    return $this->paymentOrderNotFound;
                }
            }else{
                $msg="订单验证失败".json_encode($orderArray);
                \Yii::error($msg,"order");
                return $this->paymentValidateFailed;
            }
        }else{
            $msg="获取渠道失败";
            \Yii::error($msg,"order");
            return self::$ERROR_DISTRIBUTOR_NOT_FOUND;
        }
    }

    /**
     * 检测用户登录权限
     * @param $requestData 客户端请求信息
     * @param $game 游戏信息
     */
    protected function checkLoginPremission($requestData,$game)
    {
        $blacklist=TabBlacklist::find()
            ->orWhere(['ip'=>$this->getClientIP(),'gameId'=>$game->id])
            ->orWhere(['distributionUserId'=>$requestData['uid'],'gameId'=>$game->id])
            ->orWhere(['deviceId'=>$requestData['deviceId'],'gameId'=>$game->id])->one();
        if ($blacklist)
        {
            $this->send(self::$ERROR_IN_BLACKLIST,\Yii::t('app',"您已经被禁止登录"));
        }
    }
    /**
     * 获取渠道ID
     */
    protected function getDistributionId()
    {
        $distributionId=null;
        try{
            $distributionId=\Yii::$app->request->getQueryParam('distributionId');
        }catch (Exception $exception)
        {
            \Yii::error(['Error'=>'获取分销渠道ID失败'],'payment');
        }
        return $distributionId;
    }

    /**
     * 支付回调验证，需要在派生类中实现
     * @param $distribution 分销渠道
     * @return array
     * [
     *  'orderId'=>'',
     *  'distributionOrderId'=>'',
     *  'payAmount'=>0,
     *  'payTime'=>time(),
     *  'payMode'=>'',
     * ];
     * 验证失败 返回null
     * 验证成功 必须包含 'orderId'、'distributionOrderId'、'payAmount'、'payTime'的数组,'payMode'可选
     */
    protected function orderValidate($distribution)
    {
//        固定返回格式

        return null;
    }

    /**
     * 发货
     * 根据订单ID进行发货
     * @param $orderId 我方订单号
     * @return bool 发货成功|失败
     */
    protected function deliver($orderId,$distribution)
    {
        return MyTabOrders::deliver($orderId,$distribution);
    }
    /**
     * 游戏客户端请求订单接口
     * 如果需要使用渠道侧的订单号，则需要重写改方法
     */
    public function actionCreateOrder()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $result=[];
        $model=new CreateOrder();
        $jsonData=file_get_contents("php://input");
        $requestData=json_decode(urldecode($jsonData),true);
        $model->load(['CreateOrder'=>$requestData]);

        if ($model->validate())
        {
            $distributionOrderId=null;

            $distribution=TabDistribution::find()->where(['id'=>$model->distributionId])->one();
            if ($distribution)
            {
                $order=null;
                if ($distribution->isDebug==1)//测试状态下 将订单写入到debug表中
                {
                    $model=new CreateOrderDebug();
                    $model->load(['CreateOrderDebug'=>$requestData]);
                    $order=$model->create();
                }else{
                    $order=$model->create();
                }
                if ($order!=null)
                {
                    $distributionOrder=$this->getOrderFromDistribution($requestData,$distribution,$order);

                    $result['code']=1;
                    $result['msg']='success';
                    $result['data']=[
                        'orderId'=>$order->orderId,
                        'distributionOrderId'=>$distributionOrderId
                    ];
                    if ($distributionOrder!=null)
                    {
                        $data=array_merge($result['data'],$distributionOrder);
                        $result['data']=$data;
                    }
                    return $result;
                }else{
                    LoggerHelper::OrderError($model->gameId,$model->distributionId,"订单创建失败",$model->getErrors());
                    return ['code'=>-3,'msg'=>'订单创建失败','data'=>$model->getErrors()];
                }
            }else{
                return ['code'=>-2,'msg'=>'分销渠道不存在','data'=>[]];
            }

        }else{
            return ['code'=>-1,'msg'=>'参数错误','data'=>[]];
        }
    }

    /**
     * 获取游戏版号相关信息
     * @return array|\yii\db\ActiveRecord|null
     */
    public function actionGameCopyright()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $result=[];

        $request=\Yii::$app->request;
        if ($request->get("sku"))
        {
            $game=TabGames::find()
                ->select(['copyright_number','copyright_author','copyright_press','copyright_isbn'])
                ->where(['sku'=>$request->get('sku')])
                ->asArray()
                ->one();
            if ($game!=null && count($game)>0)
            {
                return $game;
            }
        }
        return $result;
    }
    /**
     * 从渠道侧获取订单号接口,需要在派生类中重写该方法
     * return array 包含渠道订单号码及其他参数的数组
     */
    public function getOrderFromDistribution($request,$distribution,$order)
    {
        return null;
    }
    /**
     * 前往游戏服务器验证用户信息
     * @param uid 用户ID
     * @param gameid 游戏ID
     * @param pid 平台ID
     * @param sid 区服ID
     */
    public function actionNotifyLogin()
    {
        //TODO 账号、IP需要做白名单检测：测试服、进入
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $enterModle=new EnterGame();
        $request=\Yii::$app->request;
        $enterModle->load(['EnterGame'=>$request->queryParams]);
        if ($enterModle->validate())
        {
            $cache=\Yii::$app->cache;
            $token=$cache->get($request->get('token'));
            if ($token)
            {
                $gameId=$token['gameId'];
                $account=$token['account'];
                $distributionId=$token['distributionId'];
                $loginTime=time();
//                $loginKey="";//游戏服务器侧配置的key
                $game=TabGames::find()->where(['id'=>$gameId])->one();
                if($game)
                {
                    $player=TabPlayers::find()->where(['account'=>$account,'gameId'=>$gameId])->one();
                    if ($player)
                    {
                        $server=TabServers::find()->where(['gameId'=>$gameId,'id'=>$enterModle->serverId])->one();
                        if ($server)
                        {
                            $sign      = md5($account . $loginTime . $game->loginKey);
                            $requestBody=[
                                'uname'     => $account,
                                'channelId' => $distributionId,
                                'deviceId'  => $enterModle->deviceId,
                                'time'      => $loginTime,
                                'sign'      => $sign,
                                'isAdult'   => '1',
                                'serverid'  => $server->id,
                                'onlineip'  => $this->getClientIP(), //getIP(),
                            ];
                            $url="http://".$server->url."/app/cklogin.php?".http_build_query($requestBody);
                            $curl=new CurlHttpClient();
                            $resultJson=$curl->fetchUrl($url);
                            $result=json_decode($resultJson,true);
                            $msg="";
                            $code=$result['error_code'];
                            switch ($code)
                            {
                                case 1:
                                    $msg=$result['ticket'];
                                    break;
                                case -1:
                                    $msg="参数不正确";
                                    break;
                                case -2:
                                    $msg="登录会话过期";
                                    break;
                                case -3:
                                    $msg="sign验证失败";
                                    break;
                                case -4:
                                    $msg="数据库连接失败";
                                    break;
                                case -5:
                                    $msg="记录玩家登录数据出错";
                                    break;
                                case -6:
                                    $msg="玩家登录数据更新失败";
                                    break;
                                case -7:
                                    $msg="防沉迷数据库连接失败";
                                    break;
                                case -8:
                                    $msg="玩家数据记录失败";
                                    break;
                            }
                            return ['code'=>$code,'msg'=>$msg];
                        }else{
                            return ['code'=>-9,'msg'=>'无效区服'];
                        }
                    }else{
                        return ['code'=>-10,'msg'=>'无效玩家'];
                    }
                }else{
                    return ['code'=>-11,'msg'=>'登录会话过期'];
                }
            }else{
                return ['code'=>-12,'msg'=>'登录会话过期'];
            }
        }else{

            return ['code'=>-13,'msg'=>'参数错误','data'=>$enterModle->getErrors()];
        }
    }

    /**
     * 获取游戏更新接口
     * @return array
     */
    public function actionGameUpdate()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $model=new MyGameUpdate();
        return $model->getUpdateInfo();
    }
    /**
     * 获取游戏分包资源接口
     * @return array
     */
    public function actionGameAssets()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $model=new MyGameAssets();
        return $model->getAssetsInfo();
    }
    /**
     * 数据上报接口
     * 必须要：sku、distributionId、type、uid、account字段
     * @return array
     */
    public function actionRecord()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $jsonData=file_get_contents("php://input");
        $requestData=json_decode($jsonData,true);
        if ($requestData && $requestData['sku'] && $requestData['distributionId'] && $requestData['type'])
        {
            $game=TabGames::find()->where(['sku'=>$requestData['sku']])->one();
            if ($game)
            {
                $gameId=$game->id;
                $distributionId=$requestData['distributionId'];
                $distribution=TabDistribution::find()->where(['id'=>$distributionId])->one();
                if ($distribution)
                {
                    $requestData['gameId']=$gameId;
                    switch ($requestData['type'])
                    {
                        case self::$REPORT_TYPE_ENTER:
                            ModelStartLog::TabSuffix($gameId,$distributionId);
                            $enterApp=new ModelStartLog();
                            return $enterApp->doRecord($requestData);
                            break;
//                        case self::$REPORT_TYPE_SELECT_SERVER:
//                            break;
//                        case self::$REPORT_TYPE_ENTER_SERVER:
//                            break;
                        case self::$REPORT_TYPE_CREATE_ROLE:
                            ModelRoleLog::TabSuffix($gameId,$distributionId);
                            $createRole=new ModelRoleLog();
                            return $createRole->doRecord($requestData);
                            break;
                        case self::$REPORT_TYPE_ENTER_GAME:
                            ModelLoginLog::TabSuffix($gameId,$distributionId);
                            $roleLogin=new ModelLoginLog();
                            return $roleLogin->doRecord($requestData);
                            break;
                        case self::$REPORT_TYPE_ROLE_UPDATE:
                            ModelLevelLog::TabSuffix($gameId,$distributionId);
                            $levelChange=new ModelLevelLog();
                            return $levelChange->doRecord($requestData);
                            break;
                        default:
                            return ['code'=>-4,'msg'=>'未知上报类型','data'=>[]];
                    }
                }else{
                    return ['code'=>-3,'msg'=>'渠道不存在','data'=>[]];
                }

            }else{
                return ['code'=>-2,'msg'=>'游戏不存在','data'=>[]];
            }

        }else{
            return ['code'=>-1,'msg'=>'上报参数错误','data'=>[]];
        }
    }
    public function actionCdkey()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $request=\Yii::$app->request;
        $model=new ActivateCdkey();
        $model->load(['ActivateCdkey'=>$request->queryParams]);
        if ($model->validate())
        {
            //游戏检测
            $game=TabGames::find()->where(['sku'=>$model->sku])->one();
            if ($game)
            {
                //渠道检测
                $distribution=TabDistribution::findOne(['id'=>$model->distributionId]);
//                if($distribution){
                    //玩家检测
                    $player=TabPlayers::find()->where(['account'=>$model->account])->one();
                    if ($player)
                    {
                        //激活码检测
                        AutoCDKEYModel::TabSuffix($game->id,$distribution->distributorId);
                        $cdkeyModel=new AutoCDKEYModel();
                        $query=$cdkeyModel::find();
                        $query->where(['cdkey'=>$model->cdkey]);
                        $cdkey=$cdkeyModel::find()->where(['cdkey'=>$model->cdkey])->one();
                        if ($cdkey)
                        {
                            $variety=TabCdkeyVariety::findOne(['id'=>$cdkey->varietyId]);
                            if (!$cdkey->used)
                            {
                                //TODO 激活码类型限制：账号、角色只能使用一次

                                //激活码状态更改
                                $cdkey->setAttribute('used',1);
                                if($cdkey->save())
                                {
                                    //记录使用信息
                                    $model->setAttribute('gameId',$game->id);
                                    $model->setAttribute('logTime',time());
                                    if ($model->save())
                                    {
                                        //发货
                                        $server=TabServers::findOne(['id'=>$model->serverId]);
                                        $curl=new CurlHttpClient();
                                        $url='http://'.$server->url.'/app/ckgift.php?';
                                        $sign=md5($model->roleId.$model->roleName.$model->cdkey.$variety->items.$variety->name.$game->paymentKey);
                                        $body=[
                                            'roleId'=>$model->roleId,
                                            'roleName'=>$model->roleName,
                                            'cdkey'=>$model->cdkey,
                                            'variety'=>$variety->name,
                                            'item'=>$variety->items,
                                            'sign'=>$sign
                                        ];
                                        exit($url.http_build_query($body));
                                        $json=$curl->fetchUrl($url.http_build_query($body));
                                        if ($curl->getHttpResponseCode()==200)
                                        {
                                            $result=json_decode($json,true);
                                            $code=$result['code'];
                                            if ($code==1)
                                            {
                                                return ['code'=>1,'msg'=>'激活成功,请打开背包查看'];
                                            }else{
                                                //-1：参数错误 -2：连接失败 -3：数据库选取失败 -4：数据写入失败 -5：sign验证失败
                                                \Yii::error($body,'order');
                                            return ['code'=>-10,'msg'=>"激活失败[$code]"];
                                            }
                                        }else{
                                            \Yii::error($url,'cdkey');
                                            return ['code'=>-9,'msg'=>'激活出现异常'];
                                        }
                                    }else{
                                        return ['code'=>-8,'msg'=>'激活码激活失败'];
                                    }
                                }else{
                                    return ['code'=>-7,'msg'=>'激活码状态更新失败'];
                                }
                            }else{
                                return ['code'=>-6,'msg'=>'该激活码已使用'];
                            }
                        }else{
                            return ['code'=>-5,'msg'=>'激活码不存在'];
                        }
                    }else{
                        return ['code'=>-4,'msg'=>'玩家不存在'];
                    }
//                }else{
//                    return ['code'=>-3,'msg'=>'分销渠道不存在'];
//                }
            }else{
                return ['code'=>-2,'msg'=>'游戏不存在'];
            }
        }else{
            \Yii::error($model->getErrors(),'ckdey');
            return ['code'=>-1,'msg'=>'参数不正确','data'=>$model->getErrors()];
        }
    }
    /**
     * 登录验证，需要在派生类中实现
     * @param $request 请求参数
     * @param $distribution 分销渠道
     * @return player对象|null
     */
    protected function loginValidate($request,$distribution)
    {
        //成功后返回一个player对象
        return null;
    }

    /**
     * 生成中控订单，客户端如果需要使用渠道侧的订单发起充值
     * 则需要在派生类中重写该方法
     */
    protected function createOrder()
    {
        return null;
    }


    private function savePlayer($user,$request,$distribution)
    {
        $did=$distribution->id;
        //TODO 新的dist表中需要增加一个互通ID 用于处理安卓跟IOS的账号数据互通
//        if($distributor->intercommunicate)
//        {
//            $did=$distributor->intercommunicate;
//        }
        $uid=md5($distribution->gameId.$user['distributionUserId'].$did);
        $player=TabPlayers::findOne(['account'=>$uid]);
        if ($player===null)
        {
            //TODO 需要支持分表 增加登录验证速度
            $player=new TabPlayers();
            $player->distributionId=$distribution->id;
            $player->gameId=$distribution->gameId;
            $player->distributionUserId=$user['distributionUserId'];
            $player->distributionUserAccount=$user['distributionUserAccount'];
            $player->account=$uid;
            $player->regdeviceId=$request['deviceId'];
            $player->regtime=date('Y-m-d H:i:s',time());
            $player->regip=$_SERVER["REMOTE_ADDR"];
//            $player->timestamp=date('Y-m-d H:i:s',time());
            if($player->save())
            {
                return $player;
            }else{
                return null;
            }
        }
        return $player;
    }



    /**
     * 响应客户端请求
     * @param array $data
     */
    private function send($code,$message,$data=[])
    {
        $responseData=['code'=>$code,'message'=>$message,'data'=>$data];
        $response = \Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data=$responseData;
        $response->send();
        exit();
    }
    /**
     * 获取客户端IP
     * @param int $type
     * @param bool $adv 是否开启高级模式
     * @return mixed
     */
    private function getClientIP($type = 0,$adv=false)
    {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}