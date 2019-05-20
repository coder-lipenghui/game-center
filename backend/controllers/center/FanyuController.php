<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-08
 * Time: 14:44
 */

namespace backend\controllers\center;

use common\helps\CurlHelper;
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
            'uid'           => $request['distributorUserId'],
            'access_token'  => $request['distributorUserAccount'],
        );
        $result=$this->getSign($body,$distribution->publicKey);
        $response = CurlHelper::execRequest($login_url,$body);
        $body['sign']=$result['sign'];
        $response = json_decode($response);
        if ($response->code===1) {
            $player = array(
                'distributionUserId'        => $request['accountId'],
                'distributionUserAccount'   => $request['accountId'],
                'distributionId'            => $distribution->id,
            );
            return $player;
        }else{
            //ERROR 登录验证失败
        }
        return null;
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

    protected function orderValidate($distribution)
    {
        $request=\Yii::$app->request;
        $myOrderId=$request->post('cpparam');
        $distributionOrderId=$request->post('oid');
        if ($request->isPost)
        {
            $body=[
                'supplier_id'   =>  $request->post('supplier_id'),
                'uid'           =>  $request->post('uid'),
                'gid'           =>  $request->post('gid'),
                'sid'           =>  $request->post('sid'),
                'oid'           =>  $distributionOrderId,
                'goods_id'      =>  $request->post('goods_id'),
                'payway'        =>  $request->post('payway'),
                'gold'          =>  $request->post('gold'),
                'money'         =>  $request->post('money'),
                'cpparam'       =>  $myOrderId,
                'paytime'       =>  $request->post('paytime'),
                'time'          =>  $request->post('time'),
            ];
            $result=$this->getSign($body,$distribution->appPaymentKey);
            if ($result['sign'] == $request->post('sign')) {
                return [
                    'orderId'=>$myOrderId,
                    'distributionOrderId'=>$distributionOrderId,
                    'payTime'=>$request->post('paytime'),
                    'payAmount'=>$request->post('money')*100,
                    'payMode'=>$request->post('payway'),
                ];
            }
        }
        return null;
    }
}