<?php


namespace backend\models;

use Yii;

class MyGameUpdate extends TabGameUpdate
{
    public $sku="";
    public $platform="";
    public $versionCode="";
    public $versionName="";

    function rules()
    {
        return [
            [['sku','platform','version','versionCode','versionName'],'required'],
            [['sku','platform','versionCode','versionName'],'string'],
            [['gameId', 'distributionId', 'enable','version'], 'integer'],
        ];
    }
    public function getUpdateInfo()
    {
        $param=Yii::$app->request->queryParams;
        $this->load(['MyGameUpdate'=>$param]);
        if ($this->validate())
        {
            $game=TabGames::find()->where(['sku'=>$this->sku])->one();
            if ($game)
            {
                $cdn=TabCdn::find()->where(['gameId'=>$game->id])->one();
                if ($cdn)
                {
                    $query=self::find()
                        ->select(['id','versionFile','version','projectFile','distributionId'])
                        ->where(['enable'=>1])
                        ->andWhere(['>','version',$this->version])
                        ->orderBy('version DESC')
                        ->limit(1)
                        ->asArray();
//                    exit($query->createCommand()->getRawSql());
                    if ($this->distributionId)
                    {
                        $query->andWhere(['gameId'=>$game->id,'distributionId'=>$this->distributionId]);
                    }else{
                        $query->andWhere(['gameId'=>$game->id]);
                    }
                    $data=$query->one();

                    if ($data)
                    {
                        $url=$cdn->url."/".$game->id;
                        if (key_exists('distributionId',$data) && $data['distributionId'])
                        {
                            $url=$url."/".$data['distributionId']."/";
                        }else{
                            $url=$url."/default/";
                        }
                        $data['url']=$url;
                        return ['code'=>1,'msg'=>'检测到新版本','data'=>$data];
                    }else{
                        return ['code'=>0,'msg'=>'未检测到版本信息','data'=>$this->getErrors()];
                    }
                }else{
                    return ['code'=>-3,'msg'=>'未指定版本地址','data'=>$this->getErrors()];
                }
            }else{
                return ['code'=>-2,'msg'=>'游戏不存在','data'=>$this->getErrors()];
            }
        }else{
            return ['code'=>-1,'msg'=>'参数错误','data'=>$this->getErrors()];
        }
    }
}