<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-18
 * Time: 22:36
 */

namespace common\helps;


class LoggerHelper
{
    public static function PaymentError($gameId,$distributionId,$message,$errorInfo)
    {
        LoggerHelper::log(['gameId'=>$gameId,'DistributionId'=>$distributionId,'Error'=>$message,'ErrorInfo'=>$errorInfo],'payment');
    }
    public static function OrderError($gameId,$distributionId,$message,$errorInfo)
    {
//        \Yii::error($message,"order");
        LoggerHelper::log(['gameId'=>$gameId,'DistributionId'=>$distributionId,'Error'=>$message,'ErrorInfo'=>$errorInfo],'order');
    }
    public static function LoginError($gameId,$distributionId,$message,$errorInfo)
    {
        LoggerHelper::log(['gameId'=>$gameId,'DistributionId'=>$distributionId,'Error'=>$message,'ErrorInfo'=>$errorInfo],'login');
    }
    private static  function log($array,$type)
    {
        \Yii::error($array,$type);
    }
}