<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-16
 * Time: 00:33
 */

namespace common\helps;


class CurlHelper
{
    /**
     * [execJsonRequest description]
     * @param  [type]  $url     [url]
     * @param  array   $post    [post参数]
     * @param  integer $timeout [超时]
     * @param  integer $retry   [失败重试次数]
     * @param  array   $conf    [额外配置]
     * @return [type]           [description]
     */
    public static function execJsonRequest($url, $post = array(), $timeout = 30, $retry = 0, $conf = array())
    {
        $conf[CURLOPT_URL]            = $url;
        $conf[CURLOPT_HEADER]         = true;
        $conf[CURLOPT_RETURNTRANSFER] = true;
        $conf[CURLOPT_CONNECTTIMEOUT] = 8;
        $conf[CURLOPT_IPRESOLVE]      = CURL_IPRESOLVE_V4;
        $conf[CURLOPT_TIMEOUT]        = $timeout;
        if (count($post) > 0) {
            $conf[CURLOPT_POST]       = 1;
            $conf[CURLOPT_POSTFIELDS] = json_encode($post);
        }
        if (parse_url($url, PHP_URL_SCHEME) == 'https') {
            $conf[CURLOPT_SSL_VERIFYPEER] = false;
            $conf[CURLOPT_SSL_VERIFYHOST] = false;
        }
        $ch = curl_init();
        curl_setopt_array($ch, $conf);
        $n = 0;
        do {
            $n++;
            $ret       = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        } while ($http_code === 0 && $timeout > 0 && $timeout < 180 && is_numeric($retry) && $n < $retry);
        $ret = $http_code === 200 ? $ret : array('http_code' => $http_code, 'msg' => 'Page Err');
        curl_close($ch);
        return $ret;
    }
    /**
     * [execRequest description]
     * @param  [type]  $url     [url]
     * @param  array   $post    [post参数]
     * @param  integer $timeout [超时]
     * @param  integer $retry   [失败重试次数]
     * @param  array   $conf    [额外配置]
     * @return [type]           [description]
     */
    public static function execRequest($url, $post = array(), $timeout = 30, $retry = 0, $conf = array())
    {
        $conf[CURLOPT_URL]            = $url;
        $conf[CURLOPT_HEADER]         = false;
        $conf[CURLOPT_RETURNTRANSFER] = true;
        $conf[CURLOPT_CONNECTTIMEOUT] = 8;
        $conf[CURLOPT_IPRESOLVE]      = CURL_IPRESOLVE_V4;
        $conf[CURLOPT_TIMEOUT]        = $timeout;
        if (count($post) > 0) {
            $conf[CURLOPT_POST]       = 1;
            $conf[CURLOPT_POSTFIELDS] = $post;
        }
        if (parse_url($url, PHP_URL_SCHEME) == 'https') {
            $conf[CURLOPT_SSL_VERIFYPEER] = false;
            $conf[CURLOPT_SSL_VERIFYHOST] = false;
        }
        $ch = curl_init();
        curl_setopt_array($ch, $conf);
        $n = 0;
        do {
            $n++;
            $ret       = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        } while ($http_code === 0 && $timeout > 0 && $timeout < 180 && is_numeric($retry) && $n < $retry);
        $ret = $http_code === 200 ? $ret : array('http_code' => $http_code, 'msg' => 'Page Err');
        curl_close($ch);
        return $ret;
    }
}