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
                    //检测渠道差异更新
                    $query=$this->getQuery($game->id,$this->version,$this->distributionId);
                    $data=$this->getData($query,$game->id,$cdn->updateUrl);
                    if ($data)
                    {
                        return $data;
                    }else{
                        //检测统一按游戏ID的更新
                        $query=$this->getQuery($game->id,$this->version);
                        $data=$this->getData($query,$game->id,$cdn->updateUrl);
                        if ($data)
                        {
                            return $data;
                        }else{
                            return ['code'=>0,'msg'=>'未检测到版本信息','data'=>$this->getErrors()];
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
    private function getData($query,$gameId,$cdnUrl)
    {
        $data=$query->one();
        if ($data)
        {
            if ($this->platform=="mac")
            {
                $this->platform="ios";
            }
            $url=$cdnUrl."/".$gameId;
            if (key_exists('distributionId',$data) && $data['distributionId'])
            {
                $url=$url."/".$data['distributionId']."/".$this->platform."/";
            }else{
                $url=$url."/default/".$this->platform."/";
            }
            $data['url']=$url;
            return ['code'=>1,'msg'=>'检测到新版本','data'=>$data];
        }
        return null;
    }
    private function getQuery($gameId,$version,$distributionId=null)
    {
        $query=self::find()
            ->select(['id','versionFile','version','projectFile','distributionId'])
            ->where(['enable'=>1])
            ->andWhere(['>','version',$version])
            ->andWhere(['<=','executeTime',time()])
            ->andWhere(['gameId'=>$gameId])
            ->orderBy('version DESC')
            ->limit(1)
            ->asArray();
            if($distributionId)
            {
                $query->andWhere(['distributionId'=>$distributionId]);
            }else{
                $query->andWhere(['distributionId'=>null]);
            }
        return $query;
    }
}