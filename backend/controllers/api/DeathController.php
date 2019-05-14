<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-23
 * Time: 17:08
 */

namespace backend\controllers\api;

use Yii;
use backend\models\api\Death;
use yii\data\ArrayDataProvider;

class DeathController extends BaseController
{
    public $apiName="death";

    public function actionIndex()
    {
        $searchModel=new Death();
        $dataProvider=new ArrayDataProvider([
            'modelClass'=>Death::className(),
        ]);
        $request=\Yii::$app->request;
        $params=$request->queryParams;
        if (!$params)
        {
            $params=$request->post();
        }
        $searchModel->load($params);
        if ($searchModel->validate())
        {
            $page=1;
            if ($request->get('page'))
            {
                $page=$request->get('page');
            }
            $queryBody=http_build_query($searchModel->getAttributes());
            if($this->initApiUrl( $searchModel->gameid,$searchModel->pid , $searchModel->serverid,$queryBody."&page=".$page))
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
        ]);
    }
}