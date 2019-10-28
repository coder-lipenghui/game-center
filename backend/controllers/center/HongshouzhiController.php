<?php


namespace backend\controllers\center;


use common\helps\CurlHttpClient;

class HongshouzhiController extends CenterController
{

    protected function loginValidate($request, $distribution)
    {
        $url="http://g.gc.com.cn/sdk/checkUsertoken.php";
        $appKey=$distribution->appKey;
        $body=[
            'user_token'=>$request['token'],
            'mem_id'=>$request['uid'],
            'app_id'=>$distribution->appId
        ];
        $signStr = "app_id=".$body['app_id']."&mem_id=".$body['mem_id']."&user_token=".$body['user_token']."&app_key=".$appKey;
        $body['sign']=md5($signStr);
        $params = json_encode($body);

        $curl=new CurlHttpClient();

        $result=$curl->sendPostData($url,$params);
        if ($result)
        {
            $resultArr=json_encode($result,true);
            if ($resultArr['status']=='1')
            {
                $player = array(
                    'distributionUserId'        => $request['uid'],
                    'distributionUserAccount'   => $request['uid'],
                    'distributionId'            => $distribution->id,
                );
                return $player;
            }
        }
        return null;
    }

    protected function orderValidate($distribution)
    {
        //构建返回信息
        $this->paymentDeliverFailed     = "DELIVER FAILED";
        $this->paymentAmountFailed      = "AMOUNT FAILED";
        $this->paymentRepeatingOrder    = "REPEATING ORDER";
        $this->paymentValidateFailed    = "VALIDATE FAILED";
        $this->paymentSuccess           = "SUCCESS";



    }
}