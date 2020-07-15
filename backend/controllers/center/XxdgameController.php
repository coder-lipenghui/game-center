<?php


namespace backend\controllers\center;


use common\helps\CurlHttpClient;

class XxdgameController extends CenterController
{
    public function loginValidate($request, $distribution)
    {
        $player = array(
            'distributionUserId'        => $request['uid'],
            'distributionUserAccount'   => $request['userName'],
            'distributionId'            => $distribution->id,
        );
        return $player;
    }

    public function orderValidate($distribution)
    {
//        1	成功
//        2	time为空
//        3	请求超时
//        4	商户id错误
//        5	签名错误
//        6	游戏id错误
//        7	服务器id错误
//        8	服务器不存在
//        9	玩家id不存在
//        10	ip不在白名单
//        11	订单重复
//        12	服务器为开启
//        13	礼包参数错误
//        14	没有更多礼包
//        15	充值金额错误
//        16	参数不全
//        17	合作暂停
//        18	其他错误
        if (empty($distribution))
        {
            exit(json_encode(['code'=>18,'msg'=>'渠道不存在']));
        }
        $request=\Yii::$app->request;

        //构建返回信息
        $this->paymentDeliverFailed     = "DELIVER FAILED";
        $this->paymentAmountFailed      = json_encode(['code'=>15,'msg'=>'充值金额错误']);
        $this->paymentRepeatingOrder    = json_encode(['code'=>11,'msg'=>'订单重复']);
        $this->paymentValidateFailed    = json_encode(['code'=>-5,'msg'=>'签名错误']);
        $this->paymentSuccess           = json_encode(['code'=>1,'msg'=>'成功']);

        $pid=$request->get('pid');
        $gid=$request->get('gid');
        $sid=$request->get('sid');
        $uid=$request->get('uid');
        $time=$request->get('time');
        $orderid=$request->get('orderid');
        $money=$request->get('money');
        $type=$request->get('type');
        $other=$request->get('other');
        $sign=$request->get('sign');
        if (empty($pid) || empty($gid) || empty($uid) ||empty($time) || empty($orderid) || empty($money) ||empty($sign))
        {
            exit(json_encode(['code'=>16,'msg'=>'参数不全']));
        }
        $mySign=md5("$pid#$gid#$sid#$uid#$time#$orderid#$money#".$distribution->appPaymentKey);
        if ($sign===$mySign)
        {
            return [
                'orderId'=>$other,
                'distributionOrderId'=>$orderid,
                'payTime'=>$time,
                'payAmount'=>$money*100,//渠道单位元，需要改成分。
            ];
        }
        return null;
    }

}