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
    public function loginValidate($request, $distributor)
    {

        $player = array(
            'distributorPlayerId' => 'lph_'.time(),
            'nickname'            => 'lph_'.time(),
            'distributor'         => $distributor->distributor,
        );
        return $player;

        $login_url='http://i.killi.com.cn/api/check?';
        $body = array(
            'supplier_id'   => $distributor->appKey,
            't'             => time(),
            'uid'           => $request['accountId'],
            'access_token'  => $request['token'],
        );
        $result=$this->getSign($body,$distributor->publicKey);
        $response = CurlHelper::execRequest($login_url,$body);
        $body['sign']=$result['sign'];
        $response = json_decode($response);
        if ($response->code===1) {
            $player = array(
                'distributorPlayerId' => $request['accountId'],
                'nickname'            => $request['accountId'],
                'distributor'         => $distributor->distributor,
            );
            return $player;
        }else{
//            echo("url:".$login_url);
//            echo("<br/>");
//            echo("supplier_key:".$distributor->publicKey);
//            echo("<br>");
//            echo("params:".$result['params']);
//            echo("<br/>");
//            echo("sign:".$result['sign']);
//            echo("<br/>");
//            echo("code:".$response->code);
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
}