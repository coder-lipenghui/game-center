<?php
namespace backend\controllers\api;
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-15
 * Time: 22:59
 */

use backend\models\command\CmdKick;
use backend\models\command\CmdUnvoice;
use backend\models\MyTabPlayers;
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
    public $apiName="player";
    public $apiDb=1;
    public function paramParser($data)
    {
        //玩家属性信息解析
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
        if ($searchModel->validate())
        {
            $player=MyTabPlayers::find()->where(['distributionUserId'=>$searchModel->account])->one();
            if ($player)
            {
                $searchModel->account=$player->account;
            }
            $page=1;
            if ($request->get('page'))
            {
                $page=$request->get('page');
            }
            $queryBody=$searchModel->getAttributes();
            $queryBody['page']=$page;
            if($this->initApiUrl( $searchModel->gameId,$searchModel->distributorId , $searchModel->serverId,$queryBody)) {
                $result=$this->getJsonData();
                $result = json_decode($result, true);
                unset($result['_links']);
                // 暂时注释掉物品解析部分
//                $items = $result['items'];
//                for ($i = 0; $i < count($items); $i++) {
//                    $bagItems=$this->itemParser($items[$i]['item_bag']);
//                    var_dump($bagItems);
//                    $result['items'][$i]['item_bag'] = $bagItems;
//                    $result['items'][$i]['item_depot1'] = $this->itemParser($result['items'][$i]['item_depot1']);
//                    $result['items'][$i]['item_depot2'] = $this->itemParser($result['items'][$i]['item_depot2']);
//                }
                $result = json_encode($result);
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
                    'unvoiceModel'=>new CmdUnvoice(),
                    'games'=>$games,
                    'distributors'=>$distributors,
                    'servers'=>$servers,
                    'supportModel'=>$supportModel,
                ]);
            }
        }
    }
}