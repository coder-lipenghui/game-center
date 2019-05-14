<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-19
 * Time: 15:25
 * 调用周期：
 *      1.派生类中设置：ApiName
 *      2.设置访问地址：initApiUrl(),需要拼接好请求参数
 *      3.获取JSON数据：getJsonData()
 * 其他：
 *
 */

namespace backend\controllers\api;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    //游戏API接口名称
    public $apiName="";
    public $apiUrl="";
    public $apiParams="";  //RESTful查询接口 统一采用get形式 所以这边用http_build_query

//    public $searchModel;
//    public $dataProvider=new ArrayDataProvider([]);

    private $inited=false;
    /**
     * 获取游戏服务器的API接口地址
     *
     * @param $gid 游戏ID
     * @param $pid 平台ID
     * @param $sid 区服ID
     * @return string 服务器的真实url地址
     */
    protected function initApiUrl($gid,$pid,$sid,$params)
    {
        //TODO 这边后续需要获取真实的区服url
        $this->apiUrl="http://gameapi.com:8888"."/".$this->apiName."?".$params;
//        $this->apiUrl="http://s1.chiyue.314yx.com/api"."/".$this->apiName."?".$params;
        $this->inited=true;
        return $this->inited;
    }
    /**
     * 从游戏服务器API获取Json数据
     * 统一get样式
     * @param $url
     * @return bool|string
     */
    protected function getJsonData()
    {
        if ($this->inited)
        {
            $ch = curl_init($this->apiUrl);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS,"");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: text/json',
                'Content-Length: ' . strlen("")
            ));
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }
        Yii::error("未设置ApiUrl");
        return null;
    }

    /**
     * 解析背包仓库的的二进制数据
     * @param $data base64过的二进制数据
     * @return array
     */
    protected  function itemParser($data)
    {
        //TODO 这个接口需要整理到版本分类中，每个游戏有自己不同的写入规则
        $data=base64_decode($data);
        $binaryLen=strlen($data);
        $unpackFormat="lpos/ltype/lduration/lduramax/litemflag/sluck/lnumber/lcreatetime/lidentify/sprotect/lprice/llevel/llock/";
        $formatLen=48;
        $size=unpack('lcount/',$data);
        $total=$size['count'];
        $offset=4;
        $items=[];
        for ($i=0;$i<$total;$i++) {
            //将前面的int、short类型的值全部读取出来
            $item = unpack($unpackFormat,substr($data,$offset, $formatLen));
            $offset += $formatLen;
            //固定三个字符串值：itemplayer，itemfrom，itemtag
            for ($k=0; $k < 3; $k++) {
                $tempLen=0;
                for ($j=0; $j < $binaryLen; $j++) {
                    $char=unpack('a', substr($data, $offset+$j,$offset+$j+1));
                    if ($char[1]=="\0") {
                        $tempLen=$j+1;
                        break;
                    }
                }
                $temStr=unpack('a*',substr($data, $offset,$tempLen));
                $item[]=$temStr[1];
                $offset+=$tempLen;
            }
            $items[]=$item;
        }
        return $items;
    }
}