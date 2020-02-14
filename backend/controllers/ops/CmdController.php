<?php


namespace backend\controllers\ops;


use backend\models\command\BaseUniversalCmd;
use yii\web\Controller;

class CmdController extends Controller
{
    public function actionIndex()
    {
        $model=new BaseUniversalCmd();
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    public function actionCreate()
    {

    }
}