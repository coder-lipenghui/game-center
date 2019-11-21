<?php

namespace backend\controllers;

use backend\models\ExportCDKEYModel;
use backend\models\MyCdkeySearch;
use backend\models\TabCdkeyVariety;
use Yii;
use backend\models\TabCdkey;
use backend\models\TabCdkeySearch;
use backend\models\GenerateCDKEYModel;
use backend\models\AutoCDKEYModel;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CdkeyController implements the CRUD actions for TabCdkey model.
 */
class CdkeyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TabCdkey models.
     * @return mixed
     */
    public function actionIndex()
    {
        $request=Yii::$app->request;
        $gameId=0;
        $distributorId=0;
        $msg=null;//测试用的msg信息
        $page=$request->get('page');
        if(!$page)
        {
            $page=1;
        }
        if ($request->getBodyParam('MyCdkeySearch'))
        {
            $page=1;
            $params=$request->getBodyParam('MyCdkeySearch');
            if ($params['gameId'])
            {
                $gameId=$params['gameId'];
            }
            if($params['distributorId'])
            {
                $distributorId=$params['distributorId'];
            }
            MyCdkeySearch::TabSuffix($gameId,$distributorId);
        }else{
            if ($request->get('gameId') && $request->get('distributorId'))
            {
                $gameId=$request->get('gameId');
                $distributorId=$request->get('distributorId');
                MyCdkeySearch::TabSuffix($gameId,$distributorId);
            }
        }
        $searchModel = new MyCdkeySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->bodyParams);
        $dataProvider->setPagination(['params'=>['gameId'=>$gameId,'distributorId'=>$distributorId,'page'=>$page]]);
        return $this->render('index', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            'msg'=>$msg
        ]);
    }

    /**
     * Displays a single TabCdkey model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        //只用作校验、显示
        $model=new ExportCDKEYModel();
        $request=Yii::$app->request;
        $dataProvider=new ArrayDataProvider();
//        $msg=json_encode($request->bodyParams);
        if ($model->load($request->bodyParams))
        {
            if($model->validate())
            {
                //实际操作对象
                ExportCDKEYModel::TabSuffix($model->gameId,$model->distributorId);
                $myModel=new ExportCDKEYModel();
                $dataProvider->setModels($myModel->groupByVariety());
            }
        }
        return $this->render('view', [
            'model'=>$model,
//            'msg'=>$msg,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * Creates a new TabCdkey model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model =new GenerateCDKEYModel();
        $request=Yii::$app->request;
        if ($model->load($request->post()))
        {
            if ($model->validate())
            {
                AutoCDKEYModel::TabSuffix($model->gameId,$model->distributorId);//设定表后缀"游戏_分销商"进行操作

                $myModel=new AutoCDKEYModel();

                $db=Yii::$app->get('db_log');

                $values=[];
                for ($j=0;$j<$model->generateNum;$j++)
                {
                    $values[]=[
                        $model->gameId,
                        $model->distributorId,
                        $model->varietyId,
                        AutoCDKEYModel::generateCDKEY(8),
                        $model->createTime
                    ];
                }
                $cmd=$db->createCommand();
                $cmd->batchInsert($myModel::tableName(),['gameId','distributorId','varietyId','cdkey','createTime'],$values);
                $cmd->query();
                return $this->redirect(['view']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TabCdkey model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionExport($varietyId,$total,$gameId,$distributorId)
    {
        ini_set('max_execution_time',0); //设置程序的执行时间,0为无上限

        ExportCDKEYModel::TabSuffix($gameId,$distributorId);
        $model = new ExportCDKEYModel();

        $title="激活码";

        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $variety=TabCdkeyVariety::find($varietyId)->one();

        $objPHPExcel->getActiveSheet()->setCellValue('A1',  $title."类型:".$variety->getAttribute('name')." 共[$total]个");

        $data=$model->getCdkeys($varietyId);

        $step=0;
        //遍历数据
        foreach ($data as $key => $value) {
            if($step==1000){ //每次写入1000条数据清除内存
                $step=0;
                ob_flush();//清除内存
                flush();
            }
            $i=$key+2;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,  $value['cdkey']);
        }
        //下载这个表格，在浏览器输出
        $file_name = $title."_".$variety->getAttribute('name');
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");;
        header('Content-Disposition:attachment;filename='.$file_name.'.xls');
        header("Content-Transfer-Encoding:binary");
        $objWriter->save('php://output');
        die();
    }
    /**
     * Deletes an existing TabCdkey model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TabCdkey model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabCdkey the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabCdkey::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
