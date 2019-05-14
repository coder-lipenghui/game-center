<?php

namespace backend\controllers;

use Yii;
use backend\models\TabAuthGroupAccess;
use backend\models\TabAuthGroupAccessSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthgroupController implements the CRUD actions for TabAuthGroupAccess model.
 */
class AuthgroupController extends Controller
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
     * Lists all TabAuthGroupAccess models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabAuthGroupAccessSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabAuthGroupAccess model.
     * @param integer $uid
     * @param integer $group_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($uid, $group_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($uid, $group_id),
        ]);
    }

    /**
     * Creates a new TabAuthGroupAccess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabAuthGroupAccess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'uid' => $model->uid, 'group_id' => $model->group_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TabAuthGroupAccess model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $uid
     * @param integer $group_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($uid, $group_id)
    {
        $model = $this->findModel($uid, $group_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'uid' => $model->uid, 'group_id' => $model->group_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TabAuthGroupAccess model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $uid
     * @param integer $group_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($uid, $group_id)
    {
        $this->findModel($uid, $group_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TabAuthGroupAccess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $uid
     * @param integer $group_id
     * @return TabAuthGroupAccess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($uid, $group_id)
    {
        if (($model = TabAuthGroupAccess::findOne(['uid' => $uid, 'group_id' => $group_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
