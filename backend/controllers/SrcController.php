<?php

namespace backend\controllers;

use backend\models\MyTabPermission;
use backend\models\MyTabSrc;
use backend\models\TabGames;
use backend\models\TabGameVersion;
use Yii;
use backend\models\TabSrc;
use backend\models\TabSrcSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SrcController implements the CRUD actions for TabSrc model.
 */
class SrcController extends Controller
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
     * Lists all TabSrc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabSrcSearch();
        $request=Yii::$app->request;
        $version=$request->get('TabSrcSearch');
        if ($version['versionId'])
        {
            $searchModel::TabSuffix($version['versionId']);
        }
        $dataProvider = $searchModel->search($request->queryParams);
        $versions=TabGameVersion::find()->select(['id','name'])->asArray()->all();
        $versions=ArrayHelper::map($versions,'id','name');
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'versions'=>$versions
        ]);
    }

    /**
     * Displays a single TabSrc model.
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
     * Creates a new TabSrc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MyTabSrc();
        $versions=TabGameVersion::find()->select(['id','name'])->asArray()->all();
        $versions=ArrayHelper::map($versions,'id','name');
        $msg="";
        if ($model->load(Yii::$app->request->post()) && $model->uploadSrc()) {
            $msg="success";
        }

        return $this->render('create', [
            'model' => $model,
            'versions'=>$versions,
            'msg'=>$msg
        ]);
    }

    /**
     * Updates an existing TabSrc model.
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
     * Deletes an existing TabSrc model.
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
    public function actionGetSrc()
    {
        \Yii::$app->response->format=\yii\web\Response::FORMAT_JSON;
        $request=Yii::$app->request;
        $gameId=$request->get('gameId');
        $typeId=$request->get('type');
//        return $request->getQueryParams();
        $game=TabGames::find()->where(['id'=>$gameId])->one();
        if(empty($game))
        {
            return ['id'=>0,'name'=>'无记录'];
        }else{
//            MyTabSrc::TabSuffix($game->versionId);
            $model=new MyTabSrc();
            $model::TabSuffix($game->versionId);
            return $model->getSrcByType($typeId);
        }

    }
    /**
     * Finds the TabSrc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabSrc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabSrc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
