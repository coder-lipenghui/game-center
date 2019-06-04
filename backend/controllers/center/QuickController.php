<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-08
 * Time: 09:54
 */

namespace backend\controllers\center;
use common\helps\CurlHttpClient;
use common\helps\LoggerHelper;

/**
 * Class QuickController Quick接口
 * @package backend\controllers\center
 */
class QuickController extends CenterController
{
    public function loginValidate($request, $distribution)
    {
        $url='http://checkuser.sdk.quicksdk.net/v2/checkUserInfo?';

        $body = array(
            'product_code'=>$distribution->appID,
            'uid'=>$request['uid'],
            'token'=>$request['token']
        );

        //'channel_code'=>$accountId,

        $param=http_build_query($body);

        $curl=new CurlHttpClient();

        $response = $curl->fetchUrl($url.$param);

        if ($response==1)
        {
            $player = array(
                'distributionUserId'        => $request['uid'],
                'distributionUserAccount'   => $request['uid'],
                'distributionId'            => $distribution->id,
            );

            return $player;

        }else{

            LoggerHelper::LoginError($distribution->gameId,$distribution->distributionId,"登录验证失败",$response);
        }
        return null;
    }
    public function orderValidate($distribution)
    {
        //构建返回信息
        $this->paymentDeliverFailed     = "DELIVER FAILED";
        $this->paymentAmountFailed      = "AMOUNT FAILED";
        $this->paymentRepeatingOrder    = "REPEATING ORDER";
        $this->paymentValidateFailed    = "VALIDATE FAILED";
        $this->paymentSuccess           = "SUCCESS";

        $request=\Yii::$app->request;
        $ntData=$request->post('nt_data');
        $body = array(
            'nt_data' => $ntData,
            'sign'=>$request->post('sign'),
        );

        $mySign=$this->getSign($body,$distribution->appPaymentKey);

        $sign=$request->post('md5Sign');

        if ($mySign==$sign ) {

            $xmlData = $this->decode($ntData, $distribution->appLoginKey);
            $xmlArray = $this->xmltoArray($xmlData);

            return [
                'orderId'=>$xmlArray['message']['game_order'],
                'distributionOrderId'=>$xmlArray['message']['order_no'],
                'payTime'=>strtotime($xmlArray['message']['pay_time']),
                'payAmount'=>$xmlArray['message']['amount']*100,
            ];
        }else
        {
            LoggerHelper::OrderError($distribution->gameId,$distribution->distributionId,"验证失败",$request->getBodyParams());
            return false;
        }
    }
    public function getOrderFromDistribution($request)
    {
        return [
            'distributionOrderId'=>'testorderid',
            'accessKey'=>'其他字段'
        ];
    }
    //-----------------------------------------//
    //          qucik侧用到的一些方法            //
    //-----------------------------------------//

    /**
     * @param $params nt_data字段
     * @param $md5key quick后台侧的MD5Key
     * @return string
     */
    private function getSign($params,$md5key){

        return md5($params['nt_data'].$params['sign'].$md5key);
    }

    /**
     * @param $strEncode nt_data字段
     * @param $keys quick后台侧的CallBa_KEY
     * @return string
     */
    private function decode($strEncode, $keys) {
        if(empty($strEncode)){
            return $strEncode;
        }
        preg_match_all('(\d+)', $strEncode, $list);
        $list = $list[0];
        if (count($list) > 0) {
            $keys = $this->getBytes($keys);
            for ($i = 0; $i < count($list); $i++) {
                $keyVar = $keys[$i % count($keys)];
                $data[$i] =  $list[$i] - (0xff & $keyVar);
            }
            return $this->toStr($data);
        } else {
            return $strEncode;
        }
    }
    /**
     * 转成字符数据
     */
    private function getBytes($string) {
        $bytes = array();
        for($i = 0; $i < strlen($string); $i++){
            $bytes[] = ord($string[$i]);
        }
        return $bytes;
    }
    /**
     * @param $xmlstring
     * @return mixed
     */
    private function xmltoArray($xmlstring)
    {
        $xml_string_obj = simplexml_load_string($xmlstring, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS);
        return json_decode(json_encode($xml_string_obj),1);
    }
    /**
     * 转化字符串
     */
    private function toStr($bytes) {
        $str = '';
        foreach($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }
}