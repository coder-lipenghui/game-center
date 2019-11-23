<?php

namespace backend\controllers;

use backend\models\MyTabPermission;
use backend\models\TabSupportCreate;
use Yii;
use backend\models\TabSupport;
use backend\models\TabSupportSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SupportController implements the CRUD actions for TabSupport model.
 */
class SupportController extends Controller
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
     * Lists all TabSupport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $createModel=new TabSupportCreate();
        $searchModel = new TabSupportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        exit(json_encode(Yii::$app->request->queryParams));
        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();
        $distributors=ArrayHelper::map($permissionModel->allowAccessDistributor($searchModel->gameId),'id','name');
        $servers=ArrayHelper::map($permissionModel->allowAccessServer($searchModel->gameId,$searchModel->distributorId),'id','name');
        $buttons=$searchModel->buttons();
        $template=$searchModel->template();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'createModel'=>$createModel,
            'dataProvider' => $dataProvider,
            'games'=>$games,
            'distributors'=>$distributors,
            'servers'=>$servers,
            'buttons'=>$buttons,
            'template'=>$template,
        ]);
    }

    /**
     * Displays a single TabSupport model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $model=new TabSupportCreate();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new TabSupport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $model = new TabSupportCreate();
        if ($model->create())
        {
            if ($model->autoDeliver())
            {
                return ['code'=>1,'msg'=>'发放成功','info'=>'success'];
            }else{
                return ['code'=>1,'msg'=>'申请成功','info'=>'success'];
            }
        }
        return ['code'=>-1,'msg'=>'申请失败','info'=>$model->getErrors(),'param'=>Yii::$app->request->queryParams];
    }

    /**
     * Updates an existing TabSupport model.
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

    /**
     * Deletes an existing TabSupport model.
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
    public function actionAllow($id){
        $model=new TabSupportCreate();
        $model->allow($id);

        return $this->redirect(['index']);
    }
    public function actionRefuse($id)
    {
        $model=new TabSupportCreate();
        $model->refuse($id);

        return $this->redirect(['index']);
    }
    /**
     * Finds the TabSupport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabSupport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabSupport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
