<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-23
 * Time: 20:38
 */

namespace backend\controllers\api;

use yii\data\ArrayDataProvider;
use backend\models\api\TradeInfo;
use backend\models\MyTabPermission;
use yii\helpers\ArrayHelper;

class TradeController extends BaseController
{
    public $apiName="trade";

    public function actionIndex()
    {
        $searchModel=new TradeInfo();

        $dataProvider=new ArrayDataProvider([
            'modelClass'=>TradeInfo::className(),
        ]);
        $request=\Yii::$app->request;
        $params=$request->queryParams;
        if (!$params)
        {
            $params=$request->post();
        }
        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();
        $searchModel->load($params);
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
            $queryBody=http_build_query($searchModel->getAttributes());
            if($this->initApiUrl( $searchModel->gameId,$searchModel->distributorId , $searchModel->serverId,$queryBody."&page=".$page))
            {
                $jsonData=$this->getJsonData();
                $arrayData=json_decode($jsonData,true);
                unset($arrayData['_links']);
                $dataProvider->setModels($arrayData['items']);
                $dataProvider->setPagination([
                    'totalCount'=>$arrayData['_meta']['totalCount']
                ]);
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