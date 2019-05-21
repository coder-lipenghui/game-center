<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-08
 * Time: 14:44
 */

namespace backend\controllers\center;

use common\helps\CurlHttpClient;

class FanyuController extends CenterController
{

    public function loginValidate($request, $distribution)
    {
        if(false)//测试用
        {
            $player = array(
                'distributionUserId'        => 'lph_'.time(),
                'distributionUserAccount'   => 'lph_'.time(),
                'distributionId'            => $distribution->id,
            );
            return $player;
        }
        $login_url='http://i.killi.com.cn/api/check?';
        $body = array(
            'supplier_id'   => $distribution->appKey,
            't'             => time(),
            'uid'           => $request['uid'],
            'access_token'  => $request['token'],
        );
        $result=$this->getSign($body,$distribution->appLoginKey);
        $body['sign']=$result['sign'];
        $curl=new CurlHttpClient();
        $response = $curl->sendPostData($login_url,$body);
        $response = json_decode($response);
        if ($response->code===1) {
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
        $myOrderId=$request->post('cpparam');
        $distributionOrderId=$request->post('oid');

        //构建返回信息
        $this->paymentDeliverFailed     =$this->getReturnInfo(-1,"发货失败",$distributionOrderId,$myOrderId);
        $this->paymentAmountFailed      =$this->getReturnInfo(-1,"订单支付金额不匹配",$distributionOrderId,$myOrderId);
        $this->paymentRepeatingOrder    =$this->getReturnInfo(-1,"重复订单",$distributionOrderId,$myOrderId);
        $this->paymentValidateFailed    =$this->getReturnInfo(-1,"订单验证失败",$distributionOrderId,$myOrderId);
        $this->paymentSuccess           =$this->getReturnInfo( 1,"支付成功",$distributionOrderId,$myOrderId);

        if ($request->isPost)
        {
            $body=[
                'supplier_id'   =>  $request->post('supplier_id'),
                'uid'           =>  $request->post('uid'),
                'gid'           =>  $request->post('gid'),
                'sid'           =>  $request->post('sid'),
                'oid'           =>  $request->post('oid'),
                'goods_id'      =>  $request->post('goods_id'),
                'payway'        =>  $request->post('payway'),
                'gold'          =>  $request->post('gold'),
                'money'         =>  $request->post('money'),
                'cpparam'       =>  $request->post('cpparam'),
                'paytime'       =>  $request->post('paytime'),
                'time'          =>  $request->post('time'),
            ];
            $result=$this->getSign($body,"cMct7FnmpzCv2Ts6S6W31Kn4VJ9D39AW");
            if ($result['sign'] == $request->post('sign')) {

                return [
                    'orderId'=>$myOrderId,
                    'distributionOrderId'=>$distributionOrderId,
                    'payTime'=>$request->post('paytime'),
                    'payAmount'=>$request->post('money')*100,
                    'payMode'=>$request->post('payway'),
                ];
            }else{
                exit($result['sign']." ".$request->post('sign'));
            }
        }
        return null;
    }

    /**
     * 支付返回信息
     * @param $code
     * @param $msg
     * @param $oid
     * @param $fid
     * @return false|string
     */
    private function getReturnInfo($code,$msg,$oid,$fid)
    {
        $returnMsg=[
            'code'=>$code,     // 1：成功 0：重复订单 -1：内部错误
            'msg'=>$msg,     //返回信息
            'data'=>[
                'oid'=>$oid, //渠道订单号
                'fid'=>$fid  //我方订单号
            ]
        ];
        return json_encode($returnMsg);
    }
    /**
     * 获取Sign
     */
    private  function getSign($params,$key)
    {
        $_data = array();
        ksort($params);
        reset($params);
        foreach($params as $k => $v){
            $_data[] = $k . "=" . urlencode($v);
        }
        $_sign = implode('&', $_data);
        return array(
            'sign'=> strtolower(md5($_sign . $key)),
            'params'=> $_sign,
        );
    }
}