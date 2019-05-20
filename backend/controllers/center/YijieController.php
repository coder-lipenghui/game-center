<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-08
 * Time: 09:53
 */

namespace backend\controllers\center;

/**
 * Class YijieController 易接接口
 * @package backend\controllers\center
 */
class YijieController extends CenterController
{
    public function loginValidate($request,$distribution)
    {
        //正式地址
        $login_url='http://sync.1sdk.cn/login/check.html?';
        //TODO 需要确认一下 sdk 跟 app 两个参数对应的值
        $body = array(
            'sdk'=>$request['sdk'],
            'app'=>$request['app'],
            'uin'=>$request['accountId'],
            'sess'=>$request['token']
        );

        $param=http_build_query($body);
        $response = execRequest($login_url.$param);
        if ($response==0) {
            $player = array(
                'distributionUserId'        => $request['accountId'],
                'distributionUserAccount'   => $request['accountId'],
                'distributionId'            => $distribution->id,
            );
            return $player;
        }
        return null;
    }
    public function orderValidate($distribution)
    {
        $request=\Yii::$app->request;
        $param = array(
            'app' => $request->get('app'),
            'cbi'=> $request->get('cbi'),
            'ct'=>  $request->get('ct'),
            'fee'=> $request->get('fee'),
            'pt'=>  $request->get('pt'),
            'sdk'=> $request->get('sdk'),
            'ssid'=>$request->get('ssid'),
            'st'=>  $request->get('st'),
            'tcd'=> $request->get('tcd'),
            'uid'=> $request->get('uid'),
            'ver'=> $request->get('ver'),
        );
        $sign=$request->get('sign');

        ksort($param);
        $temp=array();
        foreach($param as $k=>$v)
        {
            $str=$k.'='.$v;
            array_push($temp,$str);
        }
        $signStr=join("&",$temp);
        $mySign=md5($signStr.$distribution['appPaymentKey']);
        if ($mySign==$sign && $request->get('st')==1) {
            return true;
        }else
        {
            return false;
        }
    }
}