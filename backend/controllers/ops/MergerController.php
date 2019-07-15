<?php
namespace backend\controllers\ops;
use backend\models\MyTabPermission;
use backend\models\ops\MergerModel;
use yii\web\Controller;
class MergerController extends Controller
{
    public function actionIndex()
    {
        $searchModel=new MergerModel();
        $permission=new MyTabPermission();
        $games=$permission->allowAccessGame();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'games'=>$games,
        ]);

    }
    public function actionPackage()
    {
        $searchModel=new MergerModel();
        return json_encode($searchModel->package(),JSON_UNESCAPED_UNICODE);
    }
    public function actionMerge()
    {
        $searchModel=new MergerModel();
        return json_encode($searchModel->merge(),JSON_UNESCAPED_UNICODE);
    }
    public function actionRename()
    {
        $searchModel=new MergerModel();
        return json_encode($searchModel->rename(),JSON_UNESCAPED_UNICODE);
    }
}