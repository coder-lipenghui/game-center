<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-26
 * Time: 18:27
 */

namespace common\helps\cdn;

class Cdn
{
    /**
     * 服务器商提供的secretId
     * @var string
     */
    public $secretId='';
    /**
     * 服务器商提供的secretKey
     * @var string
     */
    public $secretKey='';
    /**
     * 需要刷新的资源
     * 目录用数组形式 例:["http://xxx/directory/","http://xxx/directory/"]
     * 文件用字符串形式 例如: http://xxx/file.text
     * @var string|array
     */
    public $refreshTarget=null;

    public $refreshType="file";

    function __construct($secretId,$secretKey)
    {
        $this->secretId=$secretId;
        $this->secretKey=$secretKey;
    }
    /**
     * @param $target 需要刷新的目标 string:文件|array:目录
     * tencent侧的：secretId、secretKey
     * aliyun侧的：AccessKeyId
     * @return json|null
     */
    public function refresh($target)
    {
        $this->refreshTarget=$target;
        switch (gettype($target))
        {
            case "string":
                $this->refreshType="file";

                break;
            case "array":
                $this->refreshType="directory";
                $this->refreshTarget=join("\r\n",$target);
                break;
            default:
                $this->refreshType="unknown";
        }
        if ($this->refreshType=="unknown")
        {
            return null;
        }
        return $this->invokeCdnApi();
    }

    /**
     * 调用cdn的api接口，具体在派生类中重写
     */
    protected function invokeCdnApi()
    {

    }
}