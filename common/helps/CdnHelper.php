<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-26
 * Time: 16:53
 */

namespace common\helps;
use common\helps\Cdn\AliCdnHelper;
use common\helps\Cdn\TencentCdnHelper;
class CdnHelper
{
    public static $CDN_TENCENT="tencent";
    public static $CDN_ALIYUN="aliyun";

    /**
     * 刷新CDN资源目录
     * @param $type 服务器供应商 目前只接入了腾讯和阿里云的API操作
     * @param $refreshTarget 刷新目录
     * @param $secretId
     * @param $secretKey
     * @return json|null
     */
    public static function refresh($type,$refreshTarget,$secretId,$secretKey)
    {
        $cdn=null;
        switch ($type)
        {
            case self::$CDN_TENCENT:
                $cdn=new TencentCdnHelper($secretId,$secretKey);
                break;
            case self::$CDN_ALIYUN:
                $cdn=new AliCdnHelper($secretId,$secretKey);
                break;
        }
        if ($cdn)
        {
            return $cdn->refresh($refreshTarget);
        }
        return null;
    }
}