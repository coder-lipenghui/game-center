<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-19
 * Time: 15:15
 */

namespace backend\controllers\api;

use backend\models\api\ItemRecord;
use common\helps\ItemDefHelper;
use yii\data\ArrayDataProvider;
use backend\models\MyTabPermission;
use yii\helpers\ArrayHelper;

class ItemController extends BaseController
{
    public $apiName="itemadd";
    public $apiDb=3;
    public function actionIndex()
    {
        $searchModel=new ItemRecord();
        $dataProvider=new ArrayDataProvider([
            'modelClass'=>ItemRecord::className(),
        ]);
        $request=\Yii::$app->request;
        $params=$request->queryParams;
        if (!$params)
        {
            $params=$request->post();
        }
        $searchModel->load($params);
        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();
        $distributors=[];
        $servers=[];
        if ($searchModel->validate())
        {
            $distributors=ArrayHelper::map($permissionModel->allowAccessDistributor($searchModel->gameId),'id','name');
            $servers=ArrayHelper::map($permissionModel->allowAccessServer($searchModel->gameId,$searchModel->distributorId),'id','name');
            $page=1;
            if ($request->get('page'))
            {
                $page=$request->get('page');
            }
            if (!empty($searchModel->itemName))
            {
                $itemId=ItemDefHelper::getIdByName($searchModel->gameId,$searchModel->itemName);
                if ($searchModel->itemId=="")
                {
                    $searchModel->itemId=$itemId;
                }
            }
            $queryBody=$searchModel->getAttributes();
            $queryBody['page']=$page;
            if ($searchModel->type==2)
            {
                $this->apiName="itemrem";
            }
            if($this->initApiUrl($searchModel->gameId,$searchModel->distributorId,$searchModel->serverId,$queryBody))
            {
                $jsonData=$this->getJsonData();
                $arrayData=json_decode($jsonData,true);
                if (!empty($arrayData['items']))
                {
                    for ($i=0;$i<count($arrayData['items']);$i++)
                    {
                        $arrayData['items'][$i]['gameId']=$searchModel->gameId;
                    }
                    //exit(json_encode($arrayData['items']));
                    $dataProvider->setModels($arrayData['items']);
                    unset($arrayData['_links']);
                    $dataProvider->setPagination([
                        'totalCount'=>$arrayData['_meta']['totalCount']
                    ]);
                }

            }
        }
        return $this->render('index',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
            'games'=>$games,
            'distributors'=>$distributors,
            'servers'=>$servers,
        ]);
    }
}