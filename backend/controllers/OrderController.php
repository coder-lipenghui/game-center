<?php

namespace backend\controllers;

use backend\models\MyTabOrders;
use backend\models\TabDistribution;
use backend\models\TabDistributor;
use backend\models\TabGames;
use Yii;
use backend\models\TabOrders;
use backend\models\TabOrdersSearch;
use backend\models\TabOrdersExport;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderController implements the CRUD actions for TabOrders model.
 */
class OrderController extends Controller
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
     * Lists all TabOrders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabOrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabOrders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TabOrders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabOrders();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TabOrders model.
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
    public function actionReissue($id)
    {
        $model = $this->findModel($id);
        if (!empty($model))
        {
            $distribution=TabDistribution::find()->where(['id'=>$model->distributionId])->one();
            if (!empty($distribution))
            {
                if(MyTabOrders::deliver($model->orderId,$distribution))
                {

                }
            }
        }else{
            exit("订单信息不存在");
        }
        return $this->render('view', [
            'model' => $model,
        ]);
    }
    /**
     * Deletes an existing TabOrders model.
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
     * Finds the TabOrders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabOrders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabOrders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function actionExport()
    {
        ini_set('max_execution_time',0); //设置程序的执行时间,0为无上限
        $model = new TabOrdersExport();
        $request = Yii::$app->request;
        if (!$request->post())
        {
            return $this->render('export',[
                'model'=>$model
            ]);
        }
        $time=$request->post('TabOrdersExport')['payTime'];
        $data=$model->export($request->post());

        if($model->hasErrors())
        {
            exit(var_dump($model->getErrors()));
            return $this->render('export',[
                'model'=>$model
            ]);
        }else{
            $distributor=TabDistributor::find()->where(['id'=>$model->distributorId])->one();
            $title="[".$distributor->name."]".$time."充值订单信息";
            $games=TabGames::find()->select(['id','name'])->asArray()->all();
            $games=ArrayHelper::map($games,'id','name');
            $objPHPExcel = new \PHPExcel();
            $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
            $objPHPExcel->getActiveSheet()->setCellValue('A1',  $title);

            $objPHPExcel->getActiveSheet()->setCellValue('A2',  '游戏名称');
//            $objPHPExcel->getActiveSheet()->setCellValue('B2',  '渠道编号');
            $objPHPExcel->getActiveSheet()->setCellValue('B2',  '研发订单');
            $objPHPExcel->getActiveSheet()->setCellValue('C2',  '渠道订单');
            $objPHPExcel->getActiveSheet()->setCellValue('D2',  '金额(单位:分)');
            $objPHPExcel->getActiveSheet()->setCellValue('E2',  '支付时间');
            $step=0;
            //遍历数据
            foreach ($data as $key => $value) {
                if($step==1000){ //每次写入1000条数据清除内存
                    $step=0;
                    ob_flush();//清除内存
                    flush();
                }
                $i=$key+3;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,  $games[$value['gameId']]);
//                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,  $value['distributorId']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,  $value['orderId']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,  ($value['distributionOrderId']." "));
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,  ($value['payAmount']/100));
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,  $value['payTime']);
            }
            //下载这个表格，在浏览器输出
            $file_name = $title;
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
        }
    }
}
