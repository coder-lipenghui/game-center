<?php


namespace backend\controllers\center;


use common\helps\CurlHelper;
use common\helps\CurlHttpClient;

class DoufangController extends CenterController
{
    public function loginValidate($request, $distribution)
    {
        $url='http://sdkng.xyzs.com/checklogin';

        $body = array(
            'appid' =>$distribution->appID,
            'uid'   => $request['uid'],
            'token' => $request['token'],
        );
        $body['sign']=$this->getSign($distribution->appKey,$body);
        $curl=new CurlHttpClient();
        $response=$curl->sendPostData($url,$body);

        $response = json_decode($response,true);
        if ($response['code']==200) {
            $player = array(
                'distributionUserId'        => $request['uid'],
                'distributionUserAccount'   => $request['uid'],
                'distributionId'            => $distribution->id,
            );
            return $player;
        }else{
            //ERROR 登录验证失败
        }
        return null;
    }
    /**
     * 订单验证接口
     * @param 分销渠道 $distribution
     * @return array|null
     */
    protected function orderValidate($distribution)
    {
        $request=\Yii::$app->request;
        //我方订单
        $myOrderId=$request->post('extra');
        //渠道订单
        $distributionOrderId=$request->post('orderid');

        //构建返回信息
        $this->paymentDeliverFailed     ="fail";    //"发货失败"
        $this->paymentAmountFailed      ="fail";    //"订单支付金额不匹配"
        $this->paymentRepeatingOrder    ="fail";    //"重复订单"
        $this->paymentValidateFailed    ="fail";    //"订单验证失败"
        $this->paymentSuccess           ="success"; //"支付成功"

        if ($request->isPost)
        {
            $body=[
                'orderid'   =>  $request->post('orderid'),
                'uid'       =>  $request->post('uid'),
                'serverid'  =>  $request->post('serverid'),
                'amount'    =>  $request->post('amount'),
                'extra'     =>  $request->post('extra'),
                'ts'        =>  $request->post('ts'),
            ];
            $sign=$this->getSign($distribution->appKey,$body);
            $sig=$this->getSign($distribution->appPaymentKey, $body);
            if ($sign == $request->post('sign') && $sig==$request->post('sig')) {
                return [
                    'orderId'=>$myOrderId,
                    'distributionOrderId'=>$distributionOrderId,
                    'payTime'=>time(),
                    'payAmount'=>$request->post('amount')*100,//逗方的为元，需要转为分
                    'payMode'=>'unknown',
                ];
            }else{
                exit($sign." ".$request->post('sign'));
            }
        }
        return null;
    }
    /**
     * 获取sign
     * @param $key string
     * @param $body array
     * @return string
     */
    protected function getSign($key,$body)
    {
        ksort($body);
        $temp=array();
        foreach($body as $k=>$v)
        {
            $str=$k.'='.$v;
            array_push($temp,$str);
        }
        $signStr=$key.join("&",$temp);

        return md5($signStr);
    }
}