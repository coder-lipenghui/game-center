<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-19
 * Time: 15:15
 */

namespace backend\controllers\api;

use backend\models\api\ItemRecord;
use yii\data\ArrayDataProvider;
use backend\models\MyTabPermission;
class ItemController extends BaseController
{
    public $apiName="itemadd";

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
        if ($searchModel->validate())
        {
            $page=1;
            if ($request->get('page'))
            {
                $page=$request->get('page');
            }
            $queryBody=http_build_query($searchModel->getAttributes());
            if ($searchModel->type==2)
            {
                $this->apiName="itemrem";
            }
            if($this->initApiUrl($searchModel->gameid,$searchModel->pid,$searchModel->serverid,$queryBody."&page=".$page))
            {
                $jsonData=$this->getJsonData();
                $arrayData=json_decode($jsonData,true);
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
        ]);
    }
}