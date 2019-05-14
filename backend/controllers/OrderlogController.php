<?php

namespace backend\controllers;

use Yii;
use backend\models\TabOrdersLog;
use backend\models\TabOrdersLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderlogController implements the CRUD actions for TabOrdersLog model.
 */
class OrderlogController extends Controller
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
     * Lists all TabOrdersLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabOrdersLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabOrdersLog model.
     * @param integer $id
     * @param string $orderid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $orderid)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $orderid),
        ]);
    }

    /**
     * Creates a new TabOrdersLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabOrdersLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'orderid' => $model->orderid]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TabOrdersLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $orderid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $orderid)
    {
        $model = $this->findModel($id, $orderid);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'orderid' => $model->orderid]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TabOrdersLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $orderid
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $orderid)
    {
        $this->findModel($id, $orderid)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TabOrdersLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $orderid
     * @return TabOrdersLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $orderid)
    {
        if (($model = TabOrdersLog::findOne(['id' => $id, 'orderid' => $orderid])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
