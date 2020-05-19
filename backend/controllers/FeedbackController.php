<?php

namespace backend\controllers;

use backend\models\MyTabFeedback;
use backend\models\MyTabPermission;
use Yii;
use backend\models\TabFeedback;
use backend\models\TabFeedbackSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeedbackController implements the CRUD actions for TabFeedback model.
 */
class FeedbackController extends Controller
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
     * Lists all TabFeedback models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabFeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'games'=>$games
        ]);
    }

    /**
     * Displays a single TabFeedback model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id,$gameId,$distributorId)
    {
        return $this->render('view', [
            'model' => $this->findModel($gameId,$distributorId,$id),
        ]);
    }

    /**
     * Creates a new TabFeedback model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabFeedback();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TabFeedback model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$gameId,$distributorId)
    {
        $model = $this->findModel($id,$gameId,$distributorId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TabFeedback model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id,$gameId,$distributorId)
    {
        $this->findModel($id,$gameId,$distributorId)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TabFeedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabFeedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($gameId,$distributorId,$id)
    {
        MyTabFeedback::TabSuffix($gameId,$distributorId);
        if (($model = MyTabFeedback::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
