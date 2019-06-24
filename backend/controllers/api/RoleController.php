<?php
namespace backend\controllers\api;
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-15
 * Time: 22:59
 */

use backend\models\command\CmdKick;
use common\helps\ItemDefHelper;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use backend\models\api\RoleInfo;
use backend\models\MyTabPermission;
use yii\helpers\ArrayHelper;
use backend\models\TabSupportCreate;
class RoleController extends BaseController
{
    public $apiName="players/search";
    public function paramParser($data)
    {
        //玩家属性信息解析
    }
    public  function itemParser($data)
    {
        //exit("1");
        //TODO 这个接口需要整理到版本分类中，每个游戏有自己不同的写入规则
        $data=base64_decode($data);
        $binaryLen=strlen($data);
        $unpackFormat="lpos/ltype/lduration/lduramax/litemflag/sluck/lnumber/lcreatetime/lidentify/sprotect/lprice/llevel/llock/";
        $formatLen=48;
        $size=unpack('lcount/',$data);
        $total=$size['count'];
        $offset=4;
        $items=[];
        try{
            for ($i=0;$i<$total;$i++) {
                //将前面的int、short类型的值全部读取出来
                $item = unpack($unpackFormat,substr($data,$offset, $formatLen));
                $offset += $formatLen;
                //固定三个字符串值：itemplayer，itemfrom，itemtag
                $tempDesp=['产出玩家:','产出方式：','其他:'];
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
//                    echo($tempDesp[$k].$temStr[1]."<br/>");
                    $item[]=$temStr[1];
                    $offset+=$tempLen;
                }
                $item['type']=ItemDefHelper::getItemInfoById(1,$item['type']);
//                echo("物品信息:".json_encode($item['type'],JSON_UNESCAPED_UNICODE)."<br/>");
                //洗练属性
                $formatWashLen=20;
                $formatWash="ltype/lvalue/lvalueMax/llock/llv/";
                $wash=null;
                for ($l=0;$l<4;$l++)
                {
                    $wash=unpack($formatWash, substr($data, $offset,$formatWashLen));
                    $offset+=$formatWashLen;
                }
//                echo("洗练属性:".json_encode($wash)."<br/>");
                //鉴定属性
                $assess=null;
                $formatAssess="ltype/lvalue/lvaluemax/llv/";
                $formatAssessLen=16;
                for($m=0;$m<4;$m++)
                {
                    $assess=unpack($formatAssess,substr($data,$offset,$formatAssessLen));
                    $offset+=$formatAssessLen;
                }
//                echo("鉴定属性:".json_encode($assess)."<br/>");
                $items[]=$item;
            }
        }catch (Exception $exception)
        {
            exit("解析出现异常");
        }
//        exit(json_encode($items,JSON_UNESCAPED_UNICODE));
        return $items;
    }
    public function actionIndex()
    {
        ini_set('max_execution_time',0); //设置程序的执行时间,0为无上限
        $searchModel=new RoleInfo();
        $request=Yii::$app->request;
        $searchModel->load($request->queryParams);
        $supportModel=new TabSupportCreate();
        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();
        //$distributors=[];
        //$servers=[];
        if ($searchModel->validate())
        {
            $page=1;
            if ($request->get('page'))
            {
                $page=$request->get('page');
            }
            $queryBody=http_build_query($searchModel->getAttributes());
            if($this->initApiUrl( $searchModel->gameId,$searchModel->distributorId , $searchModel->serverId,$queryBody."&page=".$page)) {
//                exit("初始化成功");
                $result=$this->getJsonData();
                $result = json_decode($result, true);
                unset($result['_links']);
                $items = $result['items'];
                for ($i = 0; $i < count($items); $i++) {
//                    $bagItems=$this->itemParser($items[$i]['item_bag']);
//                    var_dump($bagItems);
//                    $result['items'][$i]['item_bag'] = $bagItems;
//                    $result['items'][$i]['item_depot1'] = $this->itemParser($result['items'][$i]['item_depot1']);
//                    $result['items'][$i]['item_depot2'] = $this->itemParser($result['items'][$i]['item_depot2']);
                }
                $result = json_encode($result);
//                exit(json_encode($result));
                return $result;
            }else{
                exit("初始化失败?");
            }
        }else{
            if (!$request->isAjax)
            {
                $distributors=ArrayHelper::map($permissionModel->allowAccessDistributor($searchModel->gameId),'id','name');
                $servers=ArrayHelper::map($permissionModel->allowAccessServer($searchModel->gameId,$searchModel->distributorId),'id','name');

                $page=new Pagination([
                    'totalCount'=>0,
                ]);
                return $this->render('index', [
                    'searchModel'=>$searchModel,
                    'kickModel'=>new CmdKick(),
                    'games'=>$games,
                    'distributors'=>$distributors,
                    'servers'=>$servers,
                    'supportModel'=>$supportModel,
                ]);
            }
        }
    }
}