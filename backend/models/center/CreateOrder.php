<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-17
 * Time: 18:05
 */

namespace backend\models\center;


use backend\models\TabGames;
use backend\models\TabOrders;
use backend\models\TabPlayers;
use backend\models\TabProduct;
use yii\db\Exception;


class CreateOrder extends TabOrders
{
    public $sku;
    public $roleId;
    public $roleName;
    public $roleLevel;
    public $account;
    public $serverId;
    public $serverName;
    public $money;

    public function rules()
    {
        $myRules=[
            [['account','sku','roleId','account','roleLevel','serverId','productId','serverName','money','roleName','distributionId'],'required'],
            [['sku','roleId','account','serverName','account','payStatus', 'delivered','roleName'],'string'],
            [['serverId','roleLevel','money'],'integer'],
            [['gameId', 'distributionId', 'gameServerId'], 'integer'],
            [['payAmount'], 'number'],
            [['payTime', 'createTime'], 'integer'],
            [['orderId', 'distributionOrderId', 'gameRoleName', 'gameAccount', 'productName'], 'string', 'max' => 255],
            [['distributionUserId', 'gameRoleId', 'payMode'], 'string', 'max' => 100],
            [['gameServername'], 'string', 'max' => 50],
        ];
        return $myRules;
    }
    public function create()
    {
        $cache=\Yii::$app->cache;
        $ip=$_SERVER["REMOTE_ADDR"];
        $key=$ip.$this->account;
        if ($cache->get($key))
        {
            exit("请求频率过快");
        }
        $cache->set($key,1,2);
        //游戏检测
        $gameQuery=TabGames::find()->where(['sku'=>$this->sku]);
        $game=$gameQuery->one();
        if ($game!=null)
        {
            //玩家检测
            $playerQuery=TabPlayers::find()->where(['account'=>$this->account,'distributionUserId'=>$this->distributionUserId]);
            $player=$playerQuery->one();
            if ($player!=null)
            {
                //获取计费点信息
                $productQuery=TabProduct::find()->where(['productId'=>$this->productId,'productName'=>$this->productName]);
                $product=$productQuery->one();
                if (!empty($product))
                {
                    //生成订单号
                    try{
                        $orderId=substr(md5($this->gameId.$this->distributionUserId.$this->roleId.$this->gameAccount.$this->money.microtime()),8,16);
                        $this->gameId=$game->id;
                        $this->gameServerId=$this->serverId;
                        $this->gameServername=$this->serverName;
                        $this->gameRoleId=$this->roleId;
                        $this->gameRoleName=$this->roleName;
                        $this->orderId=$orderId;
                        $this->gameAccount=$this->account;
                        $this->payAmount=$this->money;
                        $this->productId=$product->id;
                        if ($this->save())
                        {
                            return $this;
                        }else{
                            \Yii::error(['DistributionId'=>$this->distributionId,'Error'=>'新增订单失败','ErrorInfo'=>$orderId],'order');
                            return null;
                        }
                        return null;
                    }catch (Exception $exception)
                    {
                        $error=$exception->getMessage();
                        \Yii::error(['DistributionId'=>$this->distributionId,'Error'=>'新增订单异常','ErrorInfo'=>$error],'order');
                        return null;
                    }
                }else{
                    \Yii::error(['DistributionId'=>$this->distributionId,'Error'=>'不存在计费信息','ErrorInfo'=>$productQuery->createCommand()->getRawSql()],'order');
                    return null;
                }

            }else{
                \Yii::error(['DistributionId'=>$this->distributionId,'Error'=>'玩家不存在','ErrorInfo'=>$playerQuery->createCommand()->getRawSql()],'order');
                return null;
            }
        }else{
            \Yii::error(['DistributionId'=>$this->distributionId,'Error'=>'游戏不存在','ErrorInfo'=>$gameQuery->createCommand()->getRawSql()],'order');
        }
        return null;
    }
}