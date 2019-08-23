<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-24
 * Time: 16:03
 */

namespace backend\controllers\center;


use common\helps\LoggerHelper;

class TestController extends CenterController
{
    public function loginValidate($request, $distribution)
    {
        $player = array(
            'distributionUserId'        => $request['uid'],
            'distributionUserAccount'   => $request['uid'],
            'distributionId'            => $distribution->id,
        );
        return $player;
    }
    public function orderValidate($distribution)
    {
        $jsonData=file_get_contents("php://input");
        $requestData=json_decode(urldecode($jsonData),true);

        //构建返回信息
        $this->paymentDeliverFailed     = "DELIVER FAILED";
        $this->paymentAmountFailed      = "AMOUNT FAILED";
        $this->paymentRepeatingOrder    = "REPEATING ORDER";
        $this->paymentValidateFailed    = "VALIDATE FAILED";
        $this->paymentSuccess           = json_encode(['code'=>1,'msg'=>'success']);

        if ($requestData['amount'] && $requestData['orderId'])
        {
            return [
                'orderId'=>$requestData['orderId'],
                'distributionOrderId'=>$requestData['orderId'],
                'payTime'=>time(),
                'payAmount'=>$requestData['amount']*100, //单位：分
            ];
        }
    }
}