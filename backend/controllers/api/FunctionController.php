<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2020-05-16
 * Time: 20:56
 */

namespace backend\controllers\api;

use backend\models\api\FunctionModel;
use backend\models\MyTabPermission;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

class FunctionController extends BaseController
{
    public $apiName="function";
    public $apiDb=3;
    public function actionIndex()
    {
        $searchModel=new FunctionModel();
        $dataProvider=new ArrayDataProvider([
            'modelClass'=>FunctionModel::className(),
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
        if ($searchModel->validate()) {
            $distributors = ArrayHelper::map($permissionModel->allowAccessDistributor($searchModel->gameId), 'id', 'name');
            $servers = ArrayHelper::map($permissionModel->allowAccessServer($searchModel->gameId, $searchModel->distributorId), 'id', 'name');
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'games' => $games,
            'distributors' => $distributors,
            'servers' => $servers,
        ]);
    }
    public function actionPie()
    {
        $searchModel=new FunctionModel();
        $request=\Yii::$app->request;
        $params=$request->queryParams;
        if (!$params)
        {
            $params=$request->post();
        }
        $searchModel->load(['FunctionModel'=>$params]);
        if ($searchModel->validate())
        {
            return $this->getData($searchModel);
        }
    }
    public function actionBarStack()
    {
        $searchModel=new FunctionModel();
        $request=\Yii::$app->request;
        $params=$request->queryParams;
        if (!$params) {
            $params=$request->post();
        }
        $searchModel->load(['FunctionModel'=>$params]);
        if ($searchModel->validate()) {
            return $this->getData($searchModel);
        }else{
            return json_encode($searchModel->getErrors(),JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * 堆叠条形图数据
     * @param $data
     */
    private function returnBarStackData($data)
    {
        $result=[];
        $result['yAxis']=["武器","头盔","衣服","项链","护腕左","护腕右","戒指1","戒指2","腰带","靴子"];
        $result['info']=[];
        $result['total']=$data['total'];
        $maxLv=14;
        for ($i=0;$i<10;$i++)//部位
        {
            $result['legend']=[];
            $result['info'][$i]=[];
            for ($j=0;$j<$maxLv;$j++)//等级
            {
                $result['legend'][$j]="强".($j+1);
                $result['info'][$i][$j]=0;
            }
        }
        for ($i=0;$i<count($data['data']);$i++)
        {
            $info=$data['data'][$i];
            $subtype=$info['subtype'];
            $lv=$info['newlv'];
            $num=$info['num'];
            $result['info'][$subtype-1][$lv]=round($num/$data['total']*100,2);
        }
        exit(json_encode($result));
    }
    /**
     * 饼状图数据
     */
    private function returnPieData($data)
    {
        $result=[];
        $result['yAxis']=["总等级"];
        $result['legend']=[];

        //镶嵌分两种计算方式：1.N阶N星 2.N阶
        for ($i=0;$i<count($data['data']);$i++)
        {
            $info=$data['data'][$i];
            $lv=$info['newlv'];
            $num=$info['num'];
            $result['legend'][]=$lv."级";
            $result['info'][]=['value'=>$num,'name'=>$lv."级"];
        }
        exit(json_encode($result));
    }

    private function getData($model)
    {
        $queryBody=$model->getAttributes();
        if($this->initApiUrl($model->gameId,$model->distributorId,$model->serverId,$queryBody))
        {
            $jsonData=$this->getJsonData();
            $data= json_decode($jsonData,true);
            switch ($model->type)
            {
                case 10011:
                    $this->returnBarStackData($data);
                    break;
                default:
                    $this->returnPieData($data);
                    break;
            }
        }
    }

}