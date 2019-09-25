<?php


namespace backend\controllers\center;


use common\helps\CurlHttpClient;

class Xiao7Controller extends CenterController
{
    public function loginValidate($request, $distribution)
    {
        $url='https://api.x7sy.com/user/check_v4_login';
        $token=$request['token'];
        $appKey=$distribution['appKey'];

        $sign=md5($appKey.$token);
        $body= array(
            'tokenkey'=> $token,
            'sign'=>$sign
        );
        $curl=new CurlHttpClient();
        $response = $curl->sendPostData($url,$body);
        $result=json_decode($response,true);
        if ($result['errorno']==0) {
            $player = array(
                'distributionUserId'        => $request['uid'],
                'distributionUserAccount'   => $request['uid'],
                'distributionId'            => $distribution->id,
            );
            return $player;
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
        $this->paymentSuccess           = "success";

        $request=\Yii::$app->request->getBodyParams();
        $public_key=$distribution->appPublicKey;
        //"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDOsYoXhHYbNHSyaU1LLmgqy6+Pe4G2qwHonZriz4b5gJV4NOjiG03sdyt+kLZR8c4+fubBuxeHBk+XGTOAlsS0irmW2Ro8vsJgGBoYl0fDNnOuwHvAkU+vBfpi28lV3KNnO6RcDVVS/6YcApNEaALgOAD7c0G8besiXRW/vIM5SQIDAQAB";
        if (!empty($request) && count($request)>0)
        {
            $post_sign_data = base64_decode($request["sign_data"]);
            /************************************
            因为sign_data是不加入签名里面的
             ************************************/
            unset($request["sign_data"]);
            //按照参数名称的正序排序
            ksort($request);
            //对输入参数根据参数名排序，并拼接为key=value&key=value格式；
            $sourcestr=$this->http_build_query_noencode($request);
            //对数据进行验签，注意对公钥做格式转换
            $publicKey = $this->ConvertPublicKey($public_key);
            $verify = $this->Verify($sourcestr, $post_sign_data,$publicKey);
            //判断签名是否是正确
            if($verify!=1){
                return null;
            }
            //对加密的encryp_data进行解密
            $post_encryp_data_decode = base64_decode($request["encryp_data"]);
            $decode_encryp_data = $this->PublickeyDecodeing($post_encryp_data_decode,$publicKey);
            parse_str($decode_encryp_data,$encryp_data_arr);
            if(!isset($encryp_data_arr["pay_price"]) || !isset($encryp_data_arr["guid"]) || !isset($encryp_data_arr["game_orderid"])){
                return null;
            }else{
                return [
                    'orderId'=>$request['game_orderid'],
                    'distributionOrderId'=>$request['xiao7_goid'],
                    'payTime'=>time(),
                    'payAmount'=>((int)$encryp_data_arr['pay_price'])*100,
                ];
            }
        }
        return null;
    }
    public function getOrderFromDistribution($request,$distribution,$order)
    {
        $publickey=$distribution->appPublicKey;
        $signArr = [
            'game_area' => $request['serverId'],
            'game_orderid'=>$order->orderId,
            'game_price'=>number_format($order->payAmount/100, 2,".",""),
            'subject'=>$order->payAmount."金钻"
        ];
        ksort($signArr);
        $temp=array();
        foreach($signArr as $k=>$v)
        {
            $str=$k.'='.$v;
            array_push($temp,$str);
        }
        $signStr=join("&",$temp);
        $sign=md5($signStr.$publickey);
        return ['sign'=>$sign];
    }

    public function ConvertPublicKey($public_key){
        $public_key_string = "";
        $count=0;
        for($i=0;$i<strlen($public_key);$i++){
            if($count<64){
                $public_key_string.=$public_key[$i];
                $count++;
            }else{
                $public_key_string.=$public_key[$i]."\r\n";
                $count=0;
            }
        }
        $public_key_header = "-----BEGIN PUBLIC KEY-----\r\n";
        $public_key_footer = "\r\n-----END PUBLIC KEY-----";
        $public_key_string = $public_key_header.$public_key_string.$public_key_footer;
        return $public_key_string;
    }
    public function Verify($sourcestr, $sign_dataature, $publickey){
        $pkeyid = openssl_get_publickey($publickey);
        $verify = openssl_verify($sourcestr, $sign_dataature, $pkeyid);
        openssl_free_key($pkeyid);
        return $verify;
    }
    public function http_build_query_noencode($queryArr){
        if(empty($queryArr)){
            return "";
        }
        $returnArr=array();
        foreach($queryArr as $key => $value){
            $returnArr[]=$key."=".$value;
        }
        return implode("&",$returnArr);
    }
    public function PublickeyDecodeing($crypttext, $publickey){
        $pubkeyid = openssl_get_publickey($publickey);
        if (openssl_public_decrypt($crypttext, $sourcestr, $pubkeyid, OPENSSL_PKCS1_PADDING)){
            return $sourcestr;
        }
        return FALSE;
    }
}