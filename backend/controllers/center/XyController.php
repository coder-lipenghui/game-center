<?php

namespace backend\controllers\center;

use common\helps\CurlHttpClient;

class XyController extends CenterController
{

    public function loginValidate($request, $distribution)
    {
        //渠道登录验证地址
        $url = 'https://www.xy.com/xyapi/sdk/authtoken';
        //客户端SDK获取到的token
        $token = $request['token'];
        $uid=$request['uid'];
        $gid=$distribution['appID'];

        //渠道分配的验证参数信息: 常规会有 appId appKey paymentKey publicKey等
        $appKey = $distribution['appLoginKey'];//use $distribution[key] to get distribution's param

        $body=array(
            'uid'=>$uid,
            'gid'=>$gid,
            'token'=>$token,
            'time'=>time(),
        );

        $body['sign']=$this->getSign($appKey,$body);
//        exit(json_encode($body));
        $curl=new CurlHttpClient();
        $response = $curl->sendPostData($url,$body);
        $result=json_decode($response,true);
        //登录验证结果校验
        if ($result['errno']==0) {
            //必要的返回信息
            $player = array(
                'distributionUserId' => $uid,//渠道用户ID
                'distributionUserAccount' => $uid,//渠道用户名/账号，无则使用UID
                'distributionId' => $distribution->id,//渠道ID，固定请不要更改
            );
            return $player;
        }else{
            exit($response);
        }
        return null;
    }

    public function orderValidate($distribution)
    {
        //构建返回信息
        $this->paymentDeliverFailed = json_encode(['status'=>-2,'msg'=>'发货失败']);  // 发货失败
        $this->paymentAmountFailed = json_encode(['status'=>-2,'msg'=>'金额验证失败']);   // 金额验证失败
        $this->paymentRepeatingOrder = json_encode(['status'=>-8,'msg'=>'重复订单']); // 订单重复
        $this->paymentValidateFailed = json_encode(['status'=>-2,'msg'=>'订单验证失败']); // 验证失败
        $this->paymentSuccess = json_encode(['status'=>0,'msg'=>'充值成功']);         // 支付完成

        //请求参数信息
        $request = \Yii::$app->request;
//        参数信息
//        'order_id'        恺英订单号
//        'app_order_id'    cp 订单号
//        'sid'             服务器 id
//        'gid'             游戏 ID
//        'uid'             用户 id
//        'rid'             角色 id
//        'product_id'      充值产品 ID
//        'coins'           游戏元宝数
//        'money'           充值金额
//        'app_user_name'   充值角色名
//        'time'            时间戳
//        'platform_id'     平台标识
//        'extra1'          扩展字段 1
//        'extra2'

        $body=$request->getQueryParams();
        unset($body['sign']);
        unset($body['distributionId']);
        $disSign= $request->get('sign');
        $mySign=$this->getSign("#".$distribution->appPaymentKey,$body);
        if ($disSign==$mySign) {
            return [
                'orderId' => $request->get('app_order_id'),//'我方订单号，通常从透传参数或研发订单字段中获取',
                'distributionOrderId' => $request->get('order_id'),//'渠道订单号'
                'payTime' => $request->get('time'),
                'payAmount' => $request->get('money'),
            ];
        }
        return null;
    }
    protected function getSign($key,$body)
    {
        ksort($body);
        $temp=array();
        foreach($body as $k=>$v)
        {
            $str=$k.'='.urlencode($v);
            array_push($temp,$str);
        }
        $signStr=join("&",$temp).$key;
        return md5($signStr);
    }
}