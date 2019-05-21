<?php

namespace backend\controllers;

use backend\models\TabPermission;
use Yii;
use backend\models\TabServers;
use backend\models\TabServersSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ServerController implements the CRUD actions for TabServers model.
 */
class ServerController extends Controller
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
     * Lists all TabServers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabServersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabServers model.
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
     * Creates a new TabServers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabServers();
        $permissionModel=new TabPermission();
        $request=Yii::$app->request;
        $dist=[];
        $games=$permissionModel->allowAccessGame();
        if ($request->isAjax)
        {
            $requestParams=$request->getQueryParams();
            $gid=$requestParams['gameId'];
            $did=null;
            try{
                $did=$requestParams['distributorId'];
            }catch (Exception $e)
            {}
            if ($gid)
            {
                $dist=$permissionModel->allowAccessDistribution($gid,$did,Yii::$app->user->id);
            }
        }else{
            $bodyParams=$request->getBodyParams();
            if (count($bodyParams)>0)
            {
                $distributions=$bodyParams['TabServers']['distributions'];
                $bodyParams['TabServers']['distributions']=implode(",",$distributions);
                $model->load($bodyParams);
                if ($model->validate())
                {
                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'games' => $games,
            'distributions'=>$dist,
        ]);
    }

    /**
     * Updates an existing TabServers model.
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
     * Deletes an existing TabServers model.
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
     * Finds the TabServers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabServers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabServers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
