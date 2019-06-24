<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-24
 * Time: 16:34
 */

namespace backend\controllers\api;

use backend\models\api\VcoinRecord;
use yii\data\ArrayDataProvider;
use backend\models\MyTabPermission;
use yii\helpers\ArrayHelper;
class VcoinController extends BaseController
{
    public $api="vcoin";
    public $myAction="add";
    public function actionIndex()
    {
        $searchModel=new VcoinRecord();
        $dataProvider=new ArrayDataProvider([
            'modelClass'=>VcoinRecord::className(),
        ]);
        $request=\Yii::$app->request;
        $params=$request->queryParams;
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
            if ($searchModel->type==2)
            {
                $this->myAction="rem";
            }
            if ($searchModel->isBind==2)
            {
                $this->api="bvcoin";
            }
            $this->apiName=$this->api.$this->myAction;
            $queryBody=http_build_query($searchModel->getAttributes());
            if($this->initApiUrl($searchModel->gameId,$searchModel->distributorId,$searchModel->serverId,$queryBody."&page=".$page))
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