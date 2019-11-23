<?php


namespace backend\models;


use yii\db\Exception;

class MyTabBonus extends TabBonus
{
    public function getGame()
    {
        return $this->hasOne(TabGames::className(),['id'=>'gameId']);
    }
    public function getDistributor()
    {
        return $this->hasOne(TabDistributor::className(),['id'=>'distributorId']);
    }
    public static function addBonusByOrder($order)
    {
        try{
            $log=TabBonusLog::find()->where(['orderId'=>$order->orderId])->one();
            if (empty($log))
            {
                $gameId=$order->gameId;
                $distributorId=$order->distributorId;
                $payAmount=$order->payAmount/100;
                $query=TabBonus::find()->where(['gameId'=>$gameId,'distributorId'=>$distributorId]);
                $bonus=$query->one();
                if ($bonus)
                {
                    $bindRatio=$bonus->bindRatio;
                    $unbindRatio=$bonus->unbindRatio;
                    $addBindAmount=$payAmount*$bindRatio;
                    $addUnbindAmount=$payAmount*$unbindRatio;

                    $bonus->bindAmount=$bonus->bindAmount+$addBindAmount;
                    $bonus->unbindAmount=$bonus->unbindAmount+$addUnbindAmount;

                    $log=new TabBonusLog();
                    $log->gameId=$gameId;
                    $log->distributorId=$distributorId;
                    $log->orderId=$order->orderId;
                    $log->addBindAmount=$addBindAmount;
                    $log->addUnbindAmount=$addUnbindAmount;
                    $log->logTime=date('Y-m-d H:i:s',time());
                    if ($log->save())
                    {
                        if(!$bonus->save())
                        {
                            \Yii::error($bonus->getErrors(),"bonus");
                        }
                    }else{
                        \Yii::error($log->getErrors(),"bonus");
                    }
                }else{
                    \Yii::error("不存在对应的奖金池","bonus");
                }
            }else{
                \Yii::error("该笔订单已经增加过奖池","bonus");
            }
        }catch (Exception $e)
        {
            \Yii::error($e->getMessage(),"bonus");
        }
    }
}