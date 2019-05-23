<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-25
 * Time: 12:04
 */

namespace backend\controllers\api;

use backend\models\command\CmdMail;
use yii\web\Controller;
use backend\models\command\CmdKick;
use backend\models\MyTabPermission;
class CmdController extends Controller
{
    /**
     * 踢人下线
     */
    public function actionKick()
    {
        $code=0;
        $msg="命令运行失败";
        $request=\Yii::$app->request;
        $cmdModel=new CmdKick();
        $cmdModel->load($request->queryParams);
        if ($cmdModel->validate()){
            $result=$cmdModel->execu();
        }else{
            exit(var_dump($cmdModel->getErrors()));
        }
        return json_encode($result);
    }

    /**
     * 发送邮件
     * @return false|string
     */
    public function actionMail()
    {
        $code=0;
        $msg="邮件发放失败";
        $request=\Yii::$app->request;
        $mailModel=new CmdMail();
        $mailModel->load($request->queryParams);

        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();

        if ($mailModel->validate()) {
            $code = $mailModel->execu();
            $msg=$mailModel->errorMessage;
        }else{
            if ($request->isAjax)
            {
                return json_encode(['code'=>$code,'msg'=>'参数错误']);
            }
        }

        if ($request->isAjax)
        {
            return json_encode(['code'=>$code,'msg'=>$msg]);
        }
        return $this->render('mail',[
            'searchModel'=>$mailModel,
            'games'=>$games,
        ]);
    }
}