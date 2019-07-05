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
                if (false) //目前购买的不是阿里的CDN类型服务器
                {
                    $cdn=TabCdn::find()
                        ->select(['url','gameId','secretId','secretKey'])
                        ->where(['gameId'=>$this->gameId])
                        ->one();
                    if ($cdn)
                    {
                        //更新信息修改后、前往CDN进行目录刷新 5分钟生效时间
                        $refreshTarget="http://res.mysc.7you.xyz/$this->gameId/default/";
                        if ($this->distributionId)
                        {
                            $refreshTarget="http://res.mysc.7you.xyz/$this->gameId/$this->distributionId/";
                        }
                        $secretId=$cdn->secretId;
                        $secretKey=$cdn->secretKey;
                        $json=CdnHelper::refresh(CdnHelper::$CDN_ALIYUN,$refreshTarget,$secretId,$secretKey);
                        //message code
                        $result=json_decode($json,true);
                        if ($result['code'] && $result['msg'])
                        {
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        return false;
                    }
                }
                return true;
            }else{
                return false;
            }
        }
        return false;
    }
}