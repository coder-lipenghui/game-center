<?php


namespace backend\controllers\center;


class DoufangIosController extends DoufangController
{

    protected function orderValidate($distribution)
    {
        $request=\Yii::$app->request;
        //我方订单
        $myOrderId=$request->post('custom');
        //渠道订单
        $distributionOrderId=$request->post('orderid');

        //构建返回信息
//        $this->paymentDeliverFailed     ="fail";    //"发货失败"
//        $this->paymentAmountFailed      ="fail";    //"订单支付金额不匹配"
//        $this->paymentRepeatingOrder    ="fail";    //"重复订单"
//        $this->paymentValidateFailed    ="fail";    //"订单验证失败"
        $this->paymentSuccess           ="success"; //"支付成功"

        if ($request->isPost)
        {
            $body=$request->getBodyParams();
            unset($body['opensdk_sign']);
            $sig=$this->getSign($distribution->appPaymentKey, $body);
            if ($sig == $request->post('opensdk_sign')) {
                return [
                    'orderId'=>$myOrderId,
                    'distributionOrderId'=>$distributionOrderId,
                    'payTime'=>time(),
                    'payAmount'=>$request->post('amount')*100,//逗方的为元，需要转为分
                    'payMode'=>'unknown',
                ];
            }else{
                exit($sig." ".$request->post('opensdk_sign'));
            }
        }
        return null;
    }
    /**
     * 返回订单需要的签名
     * @param $request
     * @param $distribution
     * @param $order
     * @return array|null
     */
    public function getOrderFromDistribution($request,$distribution,$order)
    {
        $body=[
            'openid'=>$request['distributionUserId'],   //	string	是	平台的用户ID，登录校验时得到的
            'money'=>$request['money'],                 //	string	是	商品总金额，单位： 分。查看充值金额有限制的渠道。
            'item'=>$request['productName'],            //	string	是	商品名称
            'itemid'=>$request['productId'],            //	string	是	游戏方定义的商品ID
            'sid'=>$request['serverId'],                //	string	是	服务器id，很多渠道需要传，尽量传准确，如果没有，传1
            'sname'=>$request['serverName'],            //	string	是	服务器名称，很多渠道需要传，尽量传准确，如果没有，传1
            'roleid'=>$request['roleId'],               //  string	是	角色id，很多渠道需要传，尽量传准确，如果没有，传1
            'role_name'=>$request['roleName'],          //	string	是	角色名称，很多渠道需要传，尽量传准确，如果没有，传1
            'role_level'=>$request['roleLevel'],        //	string	是	角色等级，很多渠道需要传，尽量传准确，如果没有，传1
            'item_desc'=>$request['productName'],       //	string	否	商品描述。如果不传，用item的值
            'item_icon'=>'',                            //	string	否	商品图片地址。qqgame 渠道需要，如果不传，用默认的礼包图片
            'count'=>'1',                               //	string	否	商品数量。默认：1
            'country'=>'CN',                            //	string	否	国家码，用于区分国家信息。如US、CN、MY，符合ISO 3166标准。默认：CN
            'currency'=>'CNY',                          //	string	否	币种，用于支付的币种。如USD、CNY、MYR等，符合ISO 4217。默认：CNY
            'callback_url'=>'',                         //	string	否	发货回调地址。可选。可后台配置，也可通过本参数传。优先使用参数传的，其次是后台配置的，如果都没有就不回调。
            'appVersion'=>'1.0',                        //	string	否	游戏版本。oppo必传
            'engineVersion'=>'1.0',                     //	string	否	游戏引擎版本。oppo必传
            'custom	string'=>$order->orderId,           //	string  否	自定义透传参数，回调发货时传回发货接口，长度200
            'dev_orderid'=>$order->orderId,             //	string	否	CP订单号。可以不传，但如果传了，必须唯一。不传表示CP未创建订单，回调发货时以回调信息创建订单。
            'ts	string'=>'',                            //	string  否	时间戳
            'opensdk_sign'=>'',                         //	string	是	见kingnet_opensdk签名算法,本签名使用 paykey 生成
        ];
        $payKey=$distribution->appPaymentKey;
        unset($body['opensdk_sign']);
        $sign=$this->getSign($payKey, $body);

        return ['sign'=>$sign];
    }
}