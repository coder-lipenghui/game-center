<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-25
 * Time: 12:04
 */

namespace backend\controllers\api;

use backend\models\command\CmdMail;
use backend\models\command\CmdUnvoice;
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
        $msg=null;
        $request=\Yii::$app->request;
        $mailModel=new CmdMail();
        $mailModel->load($request->queryParams);

        $permissionModel=new MyTabPermission();
        $games=$permissionModel->allowAccessGame();

        if ($mailModel->validate()) {
            $mailModel->execu();
            $msg=$mailModel->result;
        }
        else{
            if ($request->isAjax)
            {
                return json_encode($msg,JSON_UNESCAPED_UNICODE);
            }
        }
        if ($request->isAjax)
        {
            return json_encode($msg,JSON_UNESCAPED_UNICODE);
        }
        return $this->render('mail',[
            'searchModel'=>$mailModel,
            'games'=>$games,
        ]);
    }

    /**
     * 禁言玩家
     * @return false|string
     */
    public function actionUnvoice()
    {
        $request=\Yii::$app->request;
        $cmdModel=new CmdUnvoice();
        $cmdModel->load($request->queryParams);
        if ($cmdModel->validate()){
            $result=$cmdModel->execu();
        }else{
            return json_encode($cmdModel->getErrors());
        }
        return json_encode($result);
    }
}