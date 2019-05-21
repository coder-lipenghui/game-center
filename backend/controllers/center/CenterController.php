<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-07
 * Time: 23:04
 */

namespace backend\controllers\center;

use backend\models\center\CreateOrder;
use backend\models\center\EnterGame;
use backend\models\center\Login;
use backend\models\MyTabNotice;
use backend\models\MyTabServers;
use backend\models\TabDistribution;
use backend\models\TabGames;
use backend\models\TabOrders;
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
 * @package backend\controllers\center
 */
class CenterController extends Controller
{
    public static $CODE_SUCCESS                 =  1; //成功
    public static $ERROR_SYSTEM                 = -1; //系统错误
    public static $ERROR_PARAMS                 = -2; //参数错误
    public static $ERROR_GAME_NOT_FOUND         = -3; //游戏未找到
    public static $ERROR_DISTRIBUTOR_NOT_FOUND  = -4; //分销渠道未找到
    public static $ERROR_USER_VALIDATE_FAILED   = -5; //用户登录验证失败
    public static $ERROR_ORDER_VALIDATE_FAILED  = -6; //游戏订单验证直白
    public static $ERROR_USER_SAVE_FAILED       = -7; //用户信息保存失败

    public static $ERROR_PAYMENT_PARAMS         = -1; //支付参数错误
    public static $ERROR_PAYMENT_VALIDATE_FAILED= -2; //支付订单验证失败

    public $enableCsrfValidation=false; //允许post访问

    /**支付成功返回信息，需要在派生类中重写*/
    protected $paymentSuccess;

    /**支付验证失败信息,需要在派生类中重写*/
    protected $paymentValidateFailed;

    /**订单号重复信息*/
    protected $paymentRepeatingOrder;

    /**订单金额不匹配*/
    protected $paymentAmountFailed;

    /***/
    protected $paymentDeliverFailed;

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
            //TODO 做一个sign验证
            //sign=md5(参数按首字母排序后+loginkey)
            //TODO cache检测token，如果有token 则直接跳过验证 直接拉取信息
            $game=TabGames::findOne(['sku'=>$loginModel->sku]);
            if ($game===null)
            {
                $this->send(CenterController::$ERROR_GAME_NOT_FOUND,\Yii::t('app',"未知游戏"));
            }
            $distribution=TabDistribution::findOne(['id'=>$loginModel->dist,'gameId'=>$game->id]);
            if ($distribution===null)
            {
                $this->send(CenterController::$ERROR_DISTRIBUTOR_NOT_FOUND,\Yii::t('app',"分销渠道不存在"));
            }
            $cache=\Yii::$app->cache;
//            $cache->flush();//清理缓存
//            $cache->delete($tokenKey);//根据key清理缓存
            $tokenKey=md5($requestData['uid'].$requestData['dist'].$this->getClientIP());

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
                        'distributionId'=>$user['distributionId'],
                        'account'=>$player->account
                    ],
                    10);
                $data['player']=[
                    'token'=>$tokenKey,
                    'uid'=>$player->distributionUserId
                ];
            }else{
                $data['player']=[
                    'token'=>$tokenKey,
                    'uid'=>$token['distributionUserId']
                ];
            }
            //TODO 构建公告信息 ###title|||content###title|||content
            $notice=MyTabNotice::searchGameNotice($game->id,$distribution->id);
            if (count($notice)==0)//默认构建一条公告
            {
                $notice="欢迎|||亲爱的玩家您好，欢迎来到<".$game->name.">。如果您在游戏内遇到问题，请先联系我们的客服 我们将尽快为您解决问题。";
            }
            $servers=MyTabServers::searchGameServers($game->id,$distribution->id);

            $data['serverInfo']=$servers;
            $data['anncInfo']=$notice;
        }else{
            print_r($loginModel->getErrors());
            $this->send(CenterController::$ERROR_PARAMS,\Yii::t('app',"参数错误"));
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
    public function actionPaymentCallBack()
    {
        $distributionId=$this->getDistributionId();

        if ($distributionId!=null)
        {
            $distributionQuery=TabDistribution::find()->where(['id'=>$distributionId]);
            $distribution=$distributionQuery->one();

            $orderArray=$this->orderValidate($distribution);

            if ($orderArray!=null)
            {
                $order=TabOrders::find()->where(['orderId'=>$orderArray['orderId']])->one();
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
                                if (!$this->deliver($order['orderId']))
                                {
                                    return $this->paymentDeliverFailed;
                                }
                                return $this->paymentSuccess;
                            }else{
                                $msg="支付状态更新失败";
                                \Yii::error($msg,"order");
                                return false;
                            }
                        }catch (\yii\db\Exception $exception)
                        {
                            $msg="支付状态更新失败";
                            \Yii::error($msg,"order");
                            return false;
                        }
                    }else{
                        $msg="支付金额不匹配";
                        \Yii::error($msg,"order");
                        return false;
                    }
                }else{
                    $msg="订单不存在";
                    \Yii::error($msg,"order");
                    return false;
                }
            }else{
                $msg="订单验证失败";
                \Yii::error($msg,"order");
                return false;
            }
        }else{
            $msg="获取渠道失败";
            \Yii::error($msg,"order");
            return false;
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
     * @return Array|null
     * 验证失败 返回null
     * 验证成功 必须包含 'orderId'、'distributionOrderId'、'payAmount'、'payTime'的数组,'payMode'可选
     */
    protected function orderValidate($distribution)
    {
//        固定返回格式
//        return [
//            'orderId'=>'',
//            'distributionOrderId'=>'',
//            'payAmount'=>0,
//            'payTime'=>time(),
//            'payMode'=>'',
//        ];
        return null;
    }

    /**
     * 发货
     * 根据订单ID进行发货
     * @param $orderId 我方订单号
     * @return bool 发货成功|失败
     */
    protected function deliver($orderId)
    {
        //TODO 按照渠道的充值比例进行发货，游戏记录的金额为分，默认1：100的比例。

        $orderQuery=TabOrders::find()->where(['orderId'=>$orderId]);
        $order=$orderQuery->one();
        if ($order===null)
        {
            $msg="订单不存在";
            \Yii::error($msg." orderId:".$orderId,"order");
            return false;
        }
        if ($order->payStatus>0)
        {
            $server=TabServers::find()->where(['id'=>$order->gameServerId])->one();
            if ($server===null)
            {
                $msg="区服不存在";
                LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$order->getFirstError());
                return false;
            }
            $distribution=TabDistribution::find()->where(['id'=>$order->distributionId])->one();
            if ($distribution===null)
            {
                $msg="渠道不存在";
                LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$order->getFirstError());
                return false;
            }
            $requestBody=[
                'channelId'=>$distribution->id,
                'paytouser'=>$order->gameAccount,
                'paynum'=>$order->orderId,
                'paygold'=>$order->payAmount/100*100,//发放元宝数量= 分/100*比例
                'paymoney'=>$order->payAmount/100,
                'flags'=>1,// 1：充值发放 其他：非充值发放
                'paytime'=>$order->payTime,
                'serverid'=>$order->gameServerId,
            ];

            $paymentKey='MkH3!9f*KW1BguWS6cOEzn1EPq%TRA'; //TODO 支付key需要放到tab_distribution 中 或者 tab_games中

            $requestBody['flag'] = md5($requestBody['paynum'] . urlencode($requestBody['paytouser']) . $requestBody['paygold'] . $requestBody['paytime'] . $paymentKey);

            $url="http://".$server->url."/app/ckcharge.php?".http_build_query($requestBody);

            $curl=new CurlHttpClient();
            $resultJson=$curl->fetchUrl($url);
            $result=json_decode($resultJson,true);
            $msg="";
            switch ($result['code'])
            {
                case 1:  //发货成功
                case -5: //订单重复
                    $order->delivered=1;//发货状态：0：未发货 1：已发货
                    if(!$order->save())
                    {
                        $msg="更新订单发货状态失败";
                        LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$order->getFirstError());
                    }
                    return true;
                    break;
                case -1: //防沉迷数据库连接失败
                    $msg="防沉迷数据库连接失败";
                    break;
                case -2: //账号未找到
                    $msg="[".$requestBody['paytouser']."]账号未找到";
                    break;
                case -3: //IP限制，暂时废弃
                    $msg="IP限制";
                    break;
                case -4: //sign验证出错
                    $msg="sign验证出错";
                    break;
                case -6: //超时，暂时废弃
                    $msg="超时";
                    break;
                case -8: //发货参数不全
                    $msg="发货参数不全";
                    break;
                case -9: //发货数与金额比例不正确，服务器侧写死了【paymoney*100=paygold】
                    $msg="发货数与金额比例不正确";
                    break;
            }
            LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$resultJson);
        }else{
            $msg="订单未支付成功";
            LoggerHelper::OrderError($order->gameId,$order->distributionId,$msg,$order->getFirstError());
        }
        return false;
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
        $requestData=json_decode($jsonData,true);
        $model->load(['CreateOrder'=>$requestData]);

        if ($model->validate())
        {
            $distributionOrderId=null;
            $distributionOrder=$this->getOrderFromDistribution($requestData);

            $order=$model->create();
            if ($order!=null)
            {
                $result['code']=1;
                $result['msg']='success';
                $result['data']=[
                    'orderId'=>$order->orderId,
                    'distributionOrderId'=>$distributionOrderId
                ];

                if ($distributionOrder!=null)
                {
                    $result=array_merge($result,$distributionOrder);
                }
                return $result;
            }else{
                return ['code'=>-2,'msg'=>'订单创建失败','data'=>[]];
            }
        }else{
            return ['code'=>-1,'msg'=>'参数错误','data'=>[]];
        }
    }

    /**
     * 从渠道侧获取订单号接口,需要在派生类中重写该方法
     * return array 包含渠道订单号码及其他参数的数组
     */
    public function getOrderFromDistribution($request)
    {
        return null;
    }


    public function actionGetUpdateInfo()
    {
//        $data = array();
//        $list_update=M('updates')->field('gameId,platformid,url,version,filename,SVN_version')->order('tab_updates.platformid')->select();
//        $list_game=M('games')->field('id,name')->order('id')->select();
//        $list_dist=M('dists')->field('gameId,name,distributor,platform')->order('distributor')->select();
//        if ($list_update) {
//            $data['info'] = $list_update;
//        }
//        if ($list_game) {
//            $data['games']=$list_game;
//        }
//        if ($list_dist) {
//            $data['dists']=$list_dist;
//        }
//        exit(json_encode($data));
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
        // 下发参数： uid,token token=md5(uid.)

        //TODO 检测用户、获取游戏url、前往验证
        //参数:
        $enterModle=new EnterGame();
        $request=\Yii::$app->request;
        $enterModle->load($request->queryParams);
        if ($enterModle->validate())
        {

        }else{
            $this->send(CenterController::$ERROR_PARAMS,\Yii::t('app','参数错误'));
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
//        TODO 新的dist表中需要增加一个互通ID 用于处理安卓跟IOS的账号数据互通
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
        return null;
    }



    /**
     * 响应客户端请求
     * @param array $data
     */
    private function send($code,$message,$data=[])
    {
        $responseData=['code'=>$code,'message'=>$message,'data'=>$data];
        $response = \Yii::$app->response;
//        $response->isSent=true;
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