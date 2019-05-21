<?php

namespace backend\controllers;

use backend\models\TabDistributor;
use backend\models\TabServers;
use mdm\admin\models\searchs\User;
use Yii;
use backend\models\TabPermission;
use backend\models\TabPermissionSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PermissionController implements the CRUD actions for TabPermission model.
 */
class PermissionController extends Controller
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
     * Lists all TabPermission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabPermissionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single TabPermission model.
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
     * Creates a new TabPermission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabPermission();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TabPermission model.
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
     * Deletes an existing TabPermission model.
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
     * 获取拥有权限的游戏列表
     */
    public function actionGetGame()
    {
        exit("???");
    }
    public function actionGetDistributor()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model=new TabPermission();
        $request=Yii::$app->request;
        if ($request->get('gameId'))
        {
            return $model->allowAccessDistributor($request->get('gameId'));
        }
        return ['code'=>-1,'msg'=>'获取分销商失败'];
    }
    /**
     * get distribution by game id
     */
    public function actionGetDistribution()
    {
        $model=new TabPermission();
        $response = Yii::$app->response;
        $requestParams=Yii::$app->request->getQueryParams();
        if (count($requestParams)>0)
        {
            $gid=$requestParams['gameId'];
            $did=null;
            if ($requestParams['distributorId'])
            {
                $did=$requestParams['distributorId'];
            }
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->data=$model->allowAccessDistribution($gid,$did,Yii::$app->user->id);
            $response->send();
        }

    }
    public function actionGetServer()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model=new TabPermission();
        $request=Yii::$app->request;
        if($request->get('gameId') && $request->get('distributorId'))
        {
            return $model->allowAccessServer($request->get('gameId'),$request->get('distributorId'));
        }
        return ['code'=>-1,'msg'=>'获取区服失败'];
    }
    /**
     * Finds the TabPermission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabPermission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabPermission::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
