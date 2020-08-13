<?php

namespace backend\controllers;

use backend\models\MyTabPermission;
use backend\models\TabGameVersion;
use Yii;
use backend\models\TabProduct;
use backend\models\TabProductSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for TabProduct model.
 */
class ProductController extends Controller
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
     * Lists all TabProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        $permissionModel=new MyTabPermission();
        $versions=TabGameVersion::find()->asArray()->all();
        $versions=ArrayHelper::map($versions,'id','name');

        return $this->render('index', [
            'games'=>$versions,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TabProduct model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $versions=TabGameVersion::find()->asArray()->all();
        $versions=ArrayHelper::map($versions,'id','name');
        return $this->render('view', [
            'model' => $this->findModel($id),
            'games'=>$versions
        ]);
    }

    /**
     * Creates a new TabProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TabProduct();

        $versions=TabGameVersion::find()->asArray()->all();
        $versions=ArrayHelper::map($versions,'id','name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'games'=>$versions,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TabProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $versions=TabGameVersion::find()->asArray()->all();
        $versions=ArrayHelper::map($versions,'id','name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'games'=>$versions
        ]);
    }

    /**
     * Deletes an existing TabProduct model.
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
     * Finds the TabProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
