<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-26
 * Time: 16:45
 */

namespace backend\models;
use Yii;
use common\helps\CdnHelper;

class MyTabGameUpdate extends TabGameUpdate
{

    public function adjust($id)
    {
        $model=self::findOne($id);
        if ($model)
        {
            $this->setAttributes($model->getAttributes());
            if($model->load(Yii::$app->request->post()) && $model->save())
            {
                //更新信息修改后、前往CDN进行目录刷新 5分钟生效时间
                $refreshTarget="example.com/test.txt";
                if (false)
                {
                    $secretId="testid";
                    $secretKey="testsecret";
                    $result=CdnHelper::refresh(CdnHelper::$CDN_ALIYUN,$refreshTarget,$secretId,$secretKey);
                    echo("<br/><hr/>返回结果:<br/>");
                    exit($result);
                }

                return true;
            }else{
                return false;
            }
        }
        return false;
    }
}