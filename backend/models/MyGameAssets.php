<?php


namespace backend\models;


use Yii;

class MyGameAssets extends TabGameAssets
{
    public $sku = "";
    public $platform = "";
    public $version=0;
    function rules()
    {
        return [
            [['sku','version','platform','versionCode', 'versionName'], 'required'],
            [['version','distributionId'], 'integer','min'=>0],
            [['sku','platform','versionCode', 'versionName'], 'string', 'max' => 100]
        ];
    }

    public function getAssetsInfo()
    {
        $param=Yii::$app->request->queryParams;
        $this->load(['MyGameAssets'=>$param]);
        if ($this->validate())
        {
            $game=TabGames::find()->where(['sku'=>$this->sku])->one();
            if ($game)
            {
                $cdn=TabCdn::find()->where(['versionId'=>$game->versionId,'gameId'=>$game->id])->one();
                if (empty($cdn))
                {
                    $cdn=TabCdn::find()->where(['versionId'=>$game->versionId])->one();
                }
                if ($cdn)
                {
                    //检测渠道差异更新
                    $query=$this->getQuery($game->id,$this->version,$this->distributionId,$this->versionCode);

                    $data=$this->getData($query,$game->id,$game->versionId,$this->distributionId,$cdn->assetsUrl);
                    if ($data)
                    {
                        return $data;
                    }else{
                        //检测统一按游戏ID的更新
                        $query=$this->getQuery($game->id,$this->version);
//                        exit($query->createCommand()->getRawSql());
                        $data=$this->getData($query,$game->id,$game->versionId,$this->distributionId,$cdn->assetsUrl);
                        if ($data)
                        {
                            return $data;
                        }else{
                            return ['code'=>0,'msg'=>'未检到分包资源','data'=>$this->getErrors()];
                        }
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
    private function getData($query,$gameId,$versionId,$distributionId,$cdnUrl)
    {
        $data=$query->one();
        if ($data)
        {
            if ($data['total']>$this->version && $this->version<=$data['total'])
            {
                $url=$cdnUrl."/".$versionId."/assets/";
                $data['url']=$url.($this->version+1)."/";
                $data['version']=($this->version+1);
                return ['code'=>1,'msg'=>'检到分包资源','data'=>$data];
            }else{
                return ['code'=>0,'msg'=>'未检到分包资源','data'=>$this->getErrors()];
            }
        }
        return null;
    }
    private function getTotalNum($gameId,$distributionId=null)
    {
        $query=self::find()
            ->where(['enable'=>1])
            ->andWhere(['gameId'=>$gameId]);
        if($distributionId)
        {
            $query->andWhere(['distributionId'=>$distributionId]);
        }
        return $query->count();
    }

    /**
     * 获取查询语句
     * @param $gameId 游戏ID
     * @param $version 版本号
     * @param null $distributionId 分销ID
     * @param null $versionCode 包版本号
     * @return \yii\db\ActiveQuery
     */
    private function getQuery($gameId,$version,$distributionId=null,$versionCode=null)
    {
        $query=self::find()
            ->select(['id','total','versionFile','projectFile','distributionId'])
            ->where(['enable'=>1])
            ->andWhere(['gameId'=>$gameId])
            ->andFilterWhere(['distributionId'=>$distributionId,'versionCode'=>$versionCode])
            ->limit(1)
            ->asArray();
        if (0)
        {
            exit($query->createCommand()->getRawSql());
        }
        return $query;
    }
}