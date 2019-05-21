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
use yii\data\Pagination;
use backend\models\api\RoleInfo;
use backend\models\TabPermission;
class RoleController extends BaseController
{
    public $apiName="players/search";
    public function paramParser($data)
    {
        //玩家属性信息解析
    }
    public  function itemParser($data)
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
                $item['type']=ItemDefHelper::getItemInfoById(1,$item['type']);
                $offset+=$tempLen;
            }
            $items[]=$item;
        }
        return $items;
    }
    public function actionIndex()
    {
        $searchModel=new RoleInfo();
        $request=Yii::$app->request;
        $searchModel->load($request->queryParams);

        $permissionModel=new TabPermission();
        $games=$permissionModel->allowAccessGame();

        if ($searchModel->validate())
        {
            $page=1;
            if ($request->get('page'))
            {
                $page=$request->get('page');
            }
            $queryBody=http_build_query($searchModel->getAttributes());
            if($this->initApiUrl( $searchModel->gameid,$searchModel->pid , $searchModel->serverid,$queryBody."&page=".$page)) {
                $result=$this->getJsonData();
                exit($result);
                $result = json_decode($result, true);

                $players = $result['items'];
                for ($i = 0; $i < count($players); $i++) {
                    $result['items'][$i]['item_bag'] = $this->itemParser($result['items'][$i]['item_bag']);
                    $result['items'][$i]['item_depot1'] = $this->itemParser($result['items'][$i]['item_depot1']);
                    $result['items'][$i]['item_depot2'] = $this->itemParser($result['items'][$i]['item_depot2']);
                    //                $result['items'][$i]['item_depot3']=$this->itemParser($result['items'][$i]['item_depot3']);
                }
                $result = json_encode($result);
                return $result;
            }
        }else{
            if (!$request->isAjax)
            {
                $page=new Pagination([
                    'totalCount'=>0,
                ]);
                return $this->render('index', [
                    'searchModel'=>$searchModel,
                    'kickModel'=>new CmdKick(),
                    'games'=>$games,
                ]);
            }
        }
    }
}