<?php

namespace backend\controllers;

use backend\models\MyTabGameScript;
use backend\models\MyTabPermission;
use backend\models\MyTabServers;
use backend\models\ops\MyTabUpdateScript;
use backend\models\TabGames;
use backend\models\TabGameVersion;
use Yii;
use backend\models\TabGameScript;
use backend\models\TabGameScriptSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GameScriptController implements the CRUD actions for TabGameScript model.
 */
class GameScriptController extends Controller
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
     * Lists all TabGameScript models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabGameScriptSearch();
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
     * Displays a single TabGameScript model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $gameQuery=TabGames::find()->select(['id'])->where(['versionId'=>$model->gameId])->asArray();
        $games=$gameQuery->all();
        $servers = MyTabServers::getServersByGameId(ArrayHelper::getColumn($games,'id'));
//        $servers=ArrayHelper::map($servers,"index","id","name");
        $servers=ArrayHelper::index($servers,null,"name");
        return $this->render('view', [
            'model' => $model,
            'servers'=>$servers,
        ]);
    }

    /**
     * Creates a new TabGameScript model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();
        $versions=TabGameVersion::find()->asArray()->all();
        $versions=ArrayHelper::map($versions,'id','name');
        $model = new MyTabGameScript();
        if($model->uploadZip())
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'games'=>$games,
            'versions'=>$versions,
        ]);
    }
    public function actionUpdateScript()
    {
        $model=new MyTabUpdateScript();
        return $model->doUpdate();
    }
    /**
     * Updates an existing TabGameScript model.
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
     * Deletes an existing TabGameScript model.
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
     * Finds the TabGameScript model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TabGameScript the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TabGameScript::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
