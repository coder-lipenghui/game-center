<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-07
 * Time: 23:04
 */

namespace backend\controllers\center;

use backend\events\PreTestEvent;
use backend\models\AutoCDKEYModel;
use backend\models\center\ActivateCdkey;
use backend\models\center\CreateOrder;
use backend\models\center\CreateOrderDebug;
use backend\models\center\EnterGame;
use backend\models\center\Login;
use backend\models\MyGameAssets;
use backend\models\MyGameUpdate;
use backend\models\MyTabBonus;
use backend\models\MyTabContact;
use backend\models\MyTabNotice;
use backend\models\MyTabOrders;
use backend\models\MyTabRebate;
use backend\models\MyTabServers;
use backend\models\MyTabFeedback;
use backend\models\report\ModelLevelLog;
use backend\models\report\ModelLoginLog;
use backend\models\report\ModelRoleLog;
use backend\models\report\ModelStartLog;
use backend\models\TabBlacklist;
use backend\models\MyTabDistribution;
use backend\models\TabDebugServers;
use backend\models\TabDistribution;
use backend\models\TabGames;
use backend\models\TabOrders;
use backend\models\TabOrdersDebug;
use backend\models\TabPlayers;
use backend\models\TabProduct;
use backend\models\TabServers;
use backend\models\TabWhitelist;
use common\helps\CurlHttpClient;
use common\helps\LoggerHelper;
use yii\base\Exception;
use yii\caching\Cache;
use yii\web\Controller;
use backend\events\EventDefine;
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

    public function __construct($id, $module, $config = [])
    {
        $this->on(EventDefine::$EVENT_REPORT_ENTER_SCENE,['backend\models\MyTabOrdersPretest','deliver']);
        parent::__construct($id, $module, $config);
    }

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
                $this->send(CenterController::$ERROR_GAME_NOT_FOUND,\Yii::t('app',"unknown game"));
            }
            //登录权限检测
            $this->checkLoginPremission($requestData,$game);

            $distribution=MyTabDistribution::find()->where(['id'=>$loginModel->distributionId,'gameId'=>$game->id])->one();
            if ($distribution===null)
            {
                $this->send(CenterController::$ERROR_DISTRIBUTOR_NOT_FOUND,\Yii::t('app',"unknown distribution"));
            }
            $cache=\Yii::$app->cache;
            $ip=$this->getClientIP();
            $tokenKey=md5($requestData['uid'].$requestData['distributionId'].$ip.$loginModel->deviceId);
            $token=$cache->get($tokenKey);
            if(empty($token) || $token===null || !$token)
            {
                $user=$this->loginValidate($requestData,$distribution);
                if (empty($user) || $user===null)
                {
                    $this->send(CenterController::$ERROR_USER_VALIDATE_FAILED,\Yii::t('app',"validate fail"));
                }
                $player=$this->savePlayer($user,$requestData,$distribution);
                if($player===null)
                {
                    $this->send(CenterController::$ERROR_USER_SAVE_FAILED,\Yii::t('app',"save user info fail"));
                }
                $cache->set($tokenKey,
                    [
                        'gameId'=>$game->id,
                        'distributionId'=>$user['distributionId'],
                        'account'=>$player->account,
                        'distributionUserId'=>$player->distributionUserId,
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
                    'uid'=>$token['distributionUserId'],
                    'account'=>$token['account']
                ];
            }
            $data['serverInfo']=$this->getServers($game,$distribution,$data['player']['uid'],$ip);
            $data['anncInfo']=$this->getNotice($game,$distribution);
        }else{
            $this->send(CenterController::$ERROR_PARAMS,\Yii::t('app',"param error"),'param error');
        }
        $this->send(1,'success',$data);
    }

    /**
     * 拉取区服信息
     * @param $game
     * @param $distribution
     * @param $distributionUserId
     * @param $ip
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function getServers($game,$distribution,$distributionUserId,$ip)
    {
        $servers=MyTabServers::searchGameServers($game,$distribution,$distributionUserId,$ip);
        return $servers;
    }

    /**
     * 拉取公告信息
     * @param $game
     * @param $distribution
     * @return string
     */
    protected function getNotice($game,$distribution)
    {
        //TODO 构建公告信息 ###title|||content###title|||content
        $notices=MyTabNotice::searchGameNotice($game->id,$distribution->id);
        $notice="";
        if (empty($notices))//默认构建一条公告
        {
            $notice="欢迎|||亲爱的玩家您好,如果您在游戏内遇到问题，请先联系我们的客服 我们将尽快为您解决问题。";
        }else {
            $temp=[];
            for ($i = 0; $i < count($notices); $i++){
                $item=$notices[$i]['title']."|||".$notices[$i]['body'];
                $temp[]=$item;
            }
            $notice=join("###",$temp);
        }
        return $notice;
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
            $distributionQuery=MyTabDistribution::find()->where(['id'=>$distributionId]);
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
                    if ($order->payAmount==$orderArray['payAmount'] || $distribution->isDebug==1)
                    {
                        //更新支付状态
                        $order->setAttribute('distributorId',$distribution->distributorId);
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
                                //增加奖金池额度
                                $this->addBonus($order);
                                //好友返利
                                if ($distribution->rebate>0)
                                {
                                    $this->addRebate($order,$distribution->rebate);
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
     * 问题反馈
     * @return array
     */
    public function actionFeedback()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $request=\Yii::$app->request;
        $model=new MyTabFeedback();
        $model->load(['MyTabFeedback'=>$request->queryParams]);
        if ($model->validate())
        {
            $game=TabGames::find()->where(['sku'=>$model->sku])->one();
            if (!empty($game))
            {
                $distribution=MyTabDistribution::find()->where(['id'=>$request->get('distributionId')])->one();
                if (empty($distribution))
                {
                    return ['code'=>-2,'msg'=>'未知渠道','data'=>$model->getErrors()];
                }
                $realModel=new MyTabFeedback();
                $realModel::TabSuffix($game->id,$distribution->distributorId);
                $realModel->gameId=$game->id;
                $realModel->distributorId=$distribution->distributorId;
                $realModel->load(['MyTabFeedback'=>$request->queryParams]);
                return $realModel->feedback();
            }else{
                return ['code'=>-2,'msg'=>'游戏不存在','data'=>$model->getErrors()];
            }
        }else{
            return ['code'=>-1,'msg'=>'参数错误','data'=>$model->getErrors()];
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
        if (!empty($blacklist))
        {
            $this->send(self::$ERROR_IN_BLACKLIST,\Yii::t('app',"您已经被禁止登录"));
        }
    }

    /**
     *
     * @param $order
     */
    protected function addRebate($order,$ratio)
    {
        $rebate=new MyTabRebate();
        $rebate->addRebateByOrder($order,$ratio);
    }
    /**
     * 奖金池增加
     * @param $order
     */
    protected function addBonus($order)
    {
        $bonus=new MyTabBonus();

        $bonus->addBonusByOrder($order);
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
            $distribution=MyTabDistribution::find()->where(['id'=>$model->distributionId])->one();
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
                        'distributionOrderId'=>$distributionOrderId,
                        'productName'=>$order->productName,
                        'productPrice'=>$order->payAmount,
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
            return ['code'=>-1,'msg'=>'参数错误','data'=>$model->getErrors()];
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
        $sku=$request->get("sku");
        if ($sku)
        {
            $cache=\Yii::$app->cache;
            $key='copyright_'.$request->get('sku');
            $copyrightInfo=null;//$cache->get($key);
            if ($copyrightInfo)
            {
                return $copyrightInfo;
            }else{
                $copyrightInfo=TabGames::find()
                    ->select(['copyright_number','copyright_author','copyright_press','copyright_isbn'])
                    ->where(['sku'=>$sku])
                    ->asArray()
                    ->one();
                if ($copyrightInfo!=null && count($copyrightInfo)>0)
                {
                    $cache->set($key,$copyrightInfo,600);
                    return $copyrightInfo;
                }
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
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $enterModle=new EnterGame();
        $request=\Yii::$app->request;
        $enterModle->load(['EnterGame'=>$request->queryParams]);
        if (!$enterModle->validate())return ['code'=>-13,'msg'=>'参数错误','data'=>$enterModle->getErrors()];

        $cache=\Yii::$app->cache;
        $token=$cache->get($request->get('token'));
        if (empty($token))return ['code'=>-12,'msg'=>'登录会话过期'];

        $gameId=$token['gameId'];
        $account=$token['account'];
        $distributionId=$token['distributionId'];
        $distributionUserId=$token['distributionUserId'];

        $distribution=TabDistribution::find()->where(['id'=>$distributionId])->one();
        if (empty($distribution)) return['code'=>-14,'msg'=>'未知渠道'];

        $game=TabGames::find()->where(['id'=>$gameId])->one();
        if(empty($game))return ['code'=>-11,'msg'=>'未知游戏'];

        $player=TabPlayers::find()->where(['account'=>$account,'gameId'=>$gameId])->one();
        if (empty($player))return ['code'=>-10,'msg'=>'无效玩家'];
        if ($distribution->isDebug)
        {
            $server=TabDebugServers::find()->where(['id'=>$enterModle->serverId])->one();
        }else{
            $server=TabServers::find()->where(['gameId'=>$gameId,'id'=>$enterModle->serverId])->one();
        }
        if (empty($server))return ['code'=>-9,'msg'=>'无效区服'];

        if (!empty($server->mergeId))
        {
            $server=TabServers::find()->where(['gameId'=>$gameId,'id'=>$server->mergeId])->one();
            if (empty($server))return ['code'=>-9,'msg'=>'无效区服'];
        }
        $isWhite=false;
        $ip=$this->getClientIP();
        if (!empty($distributionUserId))
        {
            $whiteQuery=TabWhitelist::find();
            $whiteQuery->where(['or',"ip='$ip'","distributionUserId='$distributionUserId'"]);
            $list=$whiteQuery->all();
            if (!empty($list))
            {
                $isWhite=true;
            }
        }
        $loginTime=time();
        $sign      = md5($account . $loginTime . $game->loginKey);
        $getBody=[
            'sku'=>$game->sku,
            'did'=>$distribution->distributorId,
            'serverId'=>$server->index,
            'db'=>2
        ];
        $postBody=[
            'uname'     => $account,
            'channelId' => $distributionId,
            'deviceId'  => $enterModle->deviceId,
            'time'      => $loginTime,
            'sign'      => $sign,
            'isAdult'   => '1',
            'serverid'  => $server->id,
            'serverIndex'=>$server->index,
            'onlineip'  => $ip, //getIP(),
        ];
        if (strtotime($server->openDateTime)>time() && !$isWhite)
        {
            return ['code'=>'-1','msg'=>'openTime:'.$server->openDateTime];
        }else{
            return $this->notifyLogin($server->url,$getBody,$postBody);
        }
    }

    protected function notifyLogin($url,$get,$post)
    {
        $curl=new CurlHttpClient();
        $resultJson=[];
        $msg="";
        if (true) //新的登录接口地址
        {
            $url="http://".$url."/api/login?".http_build_query($get);
            $resultJson=$curl->sendPostData($url,$post);
        }else{
            $url="http://".$url."/app/cklogin.php?".http_build_query($post);
            $resultJson=$curl->fetchUrl($url);
        }
        $result=json_decode($resultJson,true);
        if (empty($result['error_code']))
        {
            $code=-9;
            $msg="登录出现未知异常";
        }else{
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
                default:
                    $msg="登录出现未知异常";

            }
        }
        return ['code'=>$code."",'msg'=>$msg];
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
     * 方成谜接口
     */
    public function actionAntiAddiction()
    {

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
                $distributionUserId=$requestData['distributionUserId'];
                $serverId=$requestData['serverId'];
                $account=$requestData['account'];
                $distribution=MyTabDistribution::find()->where(['id'=>$distributionId])->one();
                if ($distribution)
                {
                    $distributorId=$distribution->distributorId;
                    $requestData['gameId']=$gameId;
                    switch ($requestData['type'])
                    {
                        case self::$REPORT_TYPE_ENTER:
                            ModelStartLog::TabSuffix($gameId,$distributorId);
                            $enterApp=new ModelStartLog();
                            return $enterApp->doRecord($requestData);
                            break;
                        case self::$REPORT_TYPE_CREATE_ROLE:
                            ModelRoleLog::TabSuffix($gameId,$distributorId);
                            $createRole=new ModelRoleLog();
                            return $createRole->doRecord($requestData);
                            break;
                        case self::$REPORT_TYPE_ENTER_GAME:

                            $roleId=$requestData['roleId'];
                            $roleName=$requestData['roleName'];

                            $pretestEvent=new PreTestEvent();
                            $pretestEvent->distributionId=$distributionId;
                            $pretestEvent->gameId=$gameId;
                            $pretestEvent->serverId=$serverId;
                            $pretestEvent->roleId=$roleId;
                            $pretestEvent->roleName=$roleName;
                            $pretestEvent->distributionUserId=$distributionUserId;
                            $pretestEvent->account=$account;
                            $this->trigger(EventDefine::$EVENT_REPORT_ENTER_SCENE,$pretestEvent);

                            ModelLoginLog::TabSuffix($gameId,$distributorId);
                            $roleLogin=new ModelLoginLog();
                            return $roleLogin->doRecord($requestData);
                            break;
                        case self::$REPORT_TYPE_ROLE_UPDATE:
                            ModelLevelLog::TabSuffix($gameId,$distributorId);
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
    public function actionContact()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $request=\Yii::$app->request;
        $model=new MyTabContact();
        $model->load(['MyTabContact'=>$request->queryParams]);
        if ($model->validate())
        {
            $game=TabGames::find()->where(['sku'=>$model->sku])->one();
            if (!empty($game))
            {
                $distribution=MyTabDistribution::find()->where(['id'=>$request->get('distributionId')])->one();
                if (empty($distribution))
                {
                    return ['code'=>-2,'msg'=>'未知渠道','data'=>$model->getErrors()];
                }
                $realModel=new MyTabContact();
                $realModel::TabSuffix($game->id,$distribution->distributorId);
                $realModel->load(['MyTabContact'=>$request->queryParams]);
                return $realModel->doBind();
            }else{
                return ['code'=>-2,'msg'=>'游戏不存在','data'=>$model->getErrors()];
            }
        }else{
            return ['code'=>-1,'msg'=>'参数错误','data'=>$model->getErrors()];
        }
    }
    public function actionCdkey()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;

        $model=new ActivateCdkey();
        return $model->useCdk();
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
            $player->distributorId=$distribution->distributorId;
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
//                exit(json_encode($player->getErrors()));
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