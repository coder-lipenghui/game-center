<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-26
 * Time: 10:02
 */

namespace backend\models\command;


use backend\models\TabAreas;
use backend\models\TabGames;
use backend\models\TabServers;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class CmdMail extends BaseCmd
{
    public $name="postmail"; //GM指令名称

    public $gameId;
    public $distributorId;
    public $serverId;       //当是全区或单人的时候
    public $type;           //全服：1、单人：2

    public $playerName;     //玩家名称[名称前面需要加user:]或seedId，如果是全服邮件 则用"all"
    public $title;          //邮件标题
    public $content;        //邮件内容
    public $items;          //邮件附件：itemid,num,itemid,num格式

    public function rules()
    {
        $parentRules= parent::rules();
        $myRules=[
            [['title','content','gameId','distributorId','type'],'required'],
            [['playerName','title','content','items'],'string'],
            ['playerName', 'required', 'when' => function($model) {
                return $model->type == 2;
            }],
            [['gameId','serverId','distributorId','type'],'integer']
        ];
        return array_merge($parentRules,$myRules);
    }
    public function attributeLabels()
    {
        $parentLabels= parent::attributeLabels();
        $myLabels=[
            'playerName'=>\Yii::t('app','玩家名称'),
            'title'=>\Yii::t('app','邮件标题'),
            'content'=>\Yii::t('app','邮件正文'),
            'items'=>\Yii::t('app','附件'),
        ];
        return array_merge($parentLabels,$myLabels);
    }

    public function buildCommand()
    {
        $this->content=str_replace("\r\n","",$this->content);
        $this->content=str_replace("\r","",$this->content);
        $this->content=str_replace("\n","",$this->content);
        if ($this->type==1)
        {
            $this->command=join(' ',[$this->name,'all',$this->title,$this->content,$this->items]);
        }
        else if ($this->type==2)
        {
            $this->command=join(' ',[$this->name,"user:".$this->playerName,$this->title,$this->content,$this->items]);
        }
    }

    public function buildServers()
    {
        $game=TabGames::find()->where(['id'=>$this->gameId])->one();
        if ($game)
        {
            $key="longcitywebonline12345678901234567890";
            $serverQuery=TabServers::find()
                ->select(['id','name','port'=>'masterPort','ip'=>'url'])
                ->where(['id'=>$this->serverId]);

            $this->serverList=$serverQuery->asArray()->all();
            $serverData=ArrayHelper::map($serverQuery->all(),'id','name');
            for ($i=0;$i<count($this->serverList);$i++)
            {
                $this->serverList[$i]['name']=$serverData[$this->serverList[$i]['id']];
                $this->serverList[$i]['secretKey']=$key;
            }

        }
    }
}