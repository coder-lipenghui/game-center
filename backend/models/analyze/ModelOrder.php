<?php


namespace backend\models\analyze;


use backend\models\MyTabPermission;
use backend\models\TabGames;
use backend\models\TabOrders;
use backend\models\TabPermission;
use backend\models\TabProduct;
use yii\helpers\ArrayHelper;

class ModelOrder extends TabOrders
{
    static function monthlyRevenue($gameId,$month=null)
    {
        $distributions=self::getDistribution($gameId);
        if ($distributions)
        {
            $query=TabOrders::find();
            return $query->where([
                'distributionId'=>$distributions,
                "FROM_UNIXTIME(payTime,'%Y-%m')"=>$month,
                'payStatus'=>'1',
            ])->sum('payAmount/100');
        }
        return 0;
    }
    function orderDistribution()
    {
        $result=[];
        $games=MyTabPermission::getGames();
        $gamesId=ArrayHelper::getColumn($games,'id');

        $games=TabGames::find()->select(['id','name'])->where(['id'=>$gamesId,'versionId'=>2])->asArray()->all();
        $gamesId=ArrayHelper::getColumn($games,'id');
        $gamesName=ArrayHelper::getColumn($games,'name');

        $products=TabProduct::find()
            ->select(['productName','productId'])
            ->where(['gameId'=>ArrayHelper::getColumn($games,'id')])
            ->groupBy('productId')
            ->orderBy('productId')
            ->asArray()
            ->all();

        $query=self::find()
            ->select(['number'=>'count(*)','revenue'=>'sum(payAmount/100)','gameId','productId'])
            ->where(['payStatus'=>'1','gameId'=>$gamesId])
            ->groupBy(['gameId','productId'])
            ->orderBy('productId')
            ->asArray();
        $data=$query->all();
        $legend=ArrayHelper::getColumn($products,'productId');
        $xAxis=ArrayHelper::getColumn($games,'name');
        $series=[];
        $data=ArrayHelper::index($data,'gameId',['productId']);
        for ($i=0;$i<count($products);$i++)
        {
            $k=$products[$i]['productId'];
            if (empty($data[$k]))
            {
                for ($i=0;$i<count($gamesId);$i++)
                {
                    $data[$k][$gamesId[$i]]=[];
                    $data[$k][$gamesId[$i]]['number']=0;
                    $data[$k][$gamesId[$i]]['revenue']=0;
                    $data[$k][$gamesId[$i]]['gameId']=$gamesId[$i];
//                    $data[$k][$gamesId[$i]]['productName']=$k;
                }
            }
        }
        foreach ($data as $k=>$v)
        {
            $tmp=[];
            $tmp['name']=$k;
            $tmp['type']='bar';
            $tmp['barGap']=0;
            $tmp['label']=array(
                'show'=>false,
//                'position'=>'top',
                'distance'=>20,
//                align: app.config.align,
//                verticalAlign: app.config.verticalAlign,
                'rotate'=>90,
                'formatter'=> '{c}|{a}',
                'fontSize'=> 10,
//                rich: {
//                name: {
//                    textBorderColor: '#fff'
//                    }
            );
            $tmp['data']=[];
            for ($i=0;$i<count($gamesId);$i++)
            {
                if (empty($v[$gamesId[$i]]))
                {
                    $data[$k][$gamesId[$i]]=[];
                    $data[$k][$gamesId[$i]]['number']=0;
                    $data[$k][$gamesId[$i]]['revenue']=0;
                    $data[$k][$gamesId[$i]]['gameId']=$gamesId[$i];
//                    $data[$k][$gamesId[$i]]['productName']=$k;
                }
                $tmp['data'][]=$data[$k][$gamesId[$i]]['number'];
            }
            $series[]=$tmp;
        }
        $result['legend']=$legend;
        $result['xAxis']=$xAxis;
        $result['series']=$series;
        return $result;
    }
    private static function getDistribution($gameId)
    {
        $distributons=null;
        $uid=\Yii::$app->user->id;
        $modelPermission=new MyTabPermission();
        $permissions=$modelPermission->getDistributionByUidAndGameId($uid,$gameId);

        if ($permissions)
        {
            $distributons=ArrayHelper::getColumn($permissions,'distributionId');
        }
        return $distributons;
    }
}