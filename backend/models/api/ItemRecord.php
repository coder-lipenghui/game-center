<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-20
 * Time: 23:39
 */
namespace backend\models\api;
use backend\models\TabActionType;
use Yii;
use yii\db\ActiveRecord;

class ItemRecord extends BaseApiModel
{
    /*API接口参数*/
//    public $playername;
    public $itemName;
    public $itemId="";
    public $type;
    public $identId;
    public $from;
    public $to;
    ///////////////////////////////
    public $id;
    public $logtime;
    public $seedname;
    public $playername;
    public $src="";
    public $mTypeID;
    public $mPosition;
    public $mDuraMax;
    public $mDuration;
    public $mItemFlags;
    public $mLuck;
    public $mNumber;
    public $mCreateTime;
    public $mIdentID;
    public function rules()
    {
        $rules=parent::rules();
        $myRules=[
//            [['itemName'],'required'],
            [['playerName','type'],'required'],
            [['itemName'],'string'],
            [['itemId','identId','src','type'],'integer'],
        ];

        return array_merge($rules,$myRules);
    }
    public function attributeLabels()
    {
        $parentLabels=parent::attributeLabels();
        $myLabels=[
            'itemName' => Yii::t('app', '物品名称'),
            'itemId' => Yii::t('app', '物品ID'),
            'type' => Yii::t('app', '操作类型'),
            'identId' => Yii::t('app', '物品唯一ID'),

            ///////////////////////////
            'id'=>Yii::t('app','编号'),
            'logtime'=>'获取时间',
            'seedname'=>Yii::t('app','角色ID'),
            'playername'=>'角色名称',
            'src'=>Yii::t('app','操作方式'),
            'mTypeID'=>Yii::t('app','物品ID'),
            'mPosition'=>Yii::t('app','记录位置'),
            'mDuraMax'=>Yii::t('app','暂时废弃'),
            'mDuration'=>Yii::t('app','暂时废弃'),
            'mItemFlags'=>Yii::t('app','暂时废弃'),
            'mLuck'=>Yii::t('app','物品幸运'),
            'mNumber'=>Yii::t('app','获取数量'),
            'mCreateTime'=>Yii::t('app','创建时间'),
            'mIdentID'=>Yii::t('app','唯一编号'),
        ];
        return array_merge($parentLabels,$myLabels);
    }


    public function getAction()
    {
        return [];
        /* @var $class ActiveRecordInterface */
        /* @var $query ActiveQuery */
//        $query = TabActionType::find();
//        $query->primaryModel = new ActiveRecord();
//        $query->link = ['actionId'=>'src'];
//        $query->multiple = false;
//        return $query;
    }
}