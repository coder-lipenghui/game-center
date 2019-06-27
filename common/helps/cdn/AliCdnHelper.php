<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-26
 * Time: 17:05
 */

namespace common\helps\cdn;

use common\helps\CurlHttpClient;

ini_set('date.timezone','Asia/Shanghai');
class AliCdnHelper extends Cdn
{
    public $HttpUrl="https://cdn.aliyuncs.com";

    private function createRequestParam()
    {
        $publicParam=[
            'Format'=>'JSON',
            'Version'=>'2018-05-10',
            'AccessKeyId'=>$this->secretId,
            'SignatureMethod'=>'HMAC-SHA1',
            'Timestamp'=>str_replace("+0800","Z",date(DATE_ISO8601,time())),
            'SignatureVersion'=>'1.0',
            'SignatureNonce'=>'9b7a44b0-3be1-11e5-8c73-08002700c460',//先用demo的
        ];

        $apiParam=[
//            等调通之后解开下面部分
//            'Action'=>'RefreshObjectCaches',
//            'ObjectPath'=>$this->refreshTarget, //刷新目标
//            'ObjectType'=>$this->refreshType,   //默认file,当ObjectType值为Directory时，ObjectPath结尾需加符号/。
            'Action'=>'DescribeCdnService'
        ];
        $param=array_merge($publicParam,$apiParam);
        $param['Signature']=$this->getSignature($param);
        return $param;
    }
    /**
     * 获取signature
     * @param $param
     * @return string
     */
    public function getSignature($param)
    {
        ksort($param);
        $temp=array();
        foreach($param as $k=>$v)
        {
            $str=$k.'='.$v;
            array_push($temp,$str);
        }
        $signStr=join("&",$temp);
        $signStr="GET"."&".urlencode('/')."&".urlencode($signStr);
        $signStr=str_replace("+","%20",$signStr);
        $signStr=str_replace("*","%2A",$signStr);
        $signStr=str_replace("%7E","~",$signStr);

        $sha1Str=hash_hmac('sha1',$signStr,$this->secretKey."&",true);
        $base64Str=base64_encode($sha1Str);
        return $base64Str;
    }
    public function invokeCdnApi()
    {
        $param=$this->createRequestParam();
//        echo("<pre>");
//        echo("请求参数:<br/>");
//        echo(var_dump($param));
//        echo("<hr/>请求url：<br/>".$this->HttpUrl."?".http_build_query($param));
        return $this->SendPost($this->HttpUrl."?".http_build_query($param),$param,true);
    }
    protected function SendPost($FullHttpUrl, $Req, $isHttps)
    {
        $curl=new CurlHttpClient();
        return $curl->fetchUrl($FullHttpUrl);
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $Req);
//
//        curl_setopt($ch, CURLOPT_URL, $FullHttpUrl);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        if ($isHttps === true) {
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
//            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
//        }
//        $result = curl_exec($ch);
//        return $result;
    }
}