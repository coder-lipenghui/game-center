<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-26
 * Time: 17:05
 */

namespace common\helps\cdn;

use common\helps\CurlHttpClient;

class AliCdnHelper extends Cdn
{
    public $HttpUrl="https://cdn.aliyuncs.com";

    public function invokeCdnApi()
    {
        $param=$this->createRequestParam();
        return $this->SendPost($this->HttpUrl."?".http_build_query($param),$param,true);
    }

    /**
     * 构建请求参数
     * @return array
     */
    private function createRequestParam()
    {
        $param=array_merge($this->getBaseParam(),$this->getActionParam());
        $param['Signature']=$this->getSignature($param);
        return $param;
    }

    /**
     * 阿里公共参数
     * @return array
     */
    protected function getBaseParam()
    {
        $publicParam=[
            'Format'=>'JSON',
            'Version'=>'2018-05-10',
            'AccessKeyId'=>$this->secretId,
            'SignatureMethod'=>'HMAC-SHA1',
            'Timestamp'=>str_replace("+0800","Z",date(DATE_ISO8601,time()-(8*60*60))),//需要减掉8个小时换算成北京时间
            'SignatureVersion'=>'1.0',
            'SignatureNonce'=>time(),//先用demo的
        ];
        return $publicParam;
    }

    /**
     * API参数
     * @return array
     */
    protected function getActionParam()
    {
        return $apiParam=[
//            等调通之后解开下面部分
            'Action'=>'RefreshObjectCaches',
            'ObjectPath'=>$this->refreshTarget, //刷新目标
            'ObjectType'=>$this->refreshType,   //默认file,当ObjectType值为Directory时，ObjectPath结尾需加符号/。
//            'Action'=>'DescribeCdnService'    //查看服务器状态
        ];
    }
    /**
     * 获取签名
     * @param $param
     * @return string
     */
    private function getSignature($param)
    {
        ksort($param);
        $temp=array();
        foreach($param as $k=>$v)
        {
            $str=$k.'='.urlencode($v);
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

    protected function SendPost($FullHttpUrl, $Req, $isHttps)
    {
        $curl=new CurlHttpClient();
        return $curl->fetchUrl($FullHttpUrl);
    }
}