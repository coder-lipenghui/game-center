<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-28
 * Time: 12:13
 */

namespace backend\models;


class AutoCDKEYModel extends TabCdkey
{
    protected static $gameId;
    protected static $distributorId;

    public static function TabSuffix($gid,$did)
    {
        self::$gameId=$gid;
        self::$distributorId=$did;
    }
    public static function tableName()
    {
        $originalName=parent::tableName();
        if (self::$gameId && self::$distributorId)
        {
            return $originalName.'_'.self::$gameId.'_'.self::$distributorId;
        }
        return $originalName;
    }

    /**
     * 生成8位或10位激活码
     */
    public static function generateCDKEY($len)
    {
        if($len!=8 && $len!=10)
        {
            $len=8;
        }
        //去掉l和o避免l1、0o混淆
        $a_z=[
            'a','b','c','d','e','f',
            'g','h','j','q','i','m',
            'n','p','q','r','s','t',
            'u','v','w','x','y','z',
        ];
        //去掉1和O避免l1、0O混淆
        $number=['2','3','4','5','6','7','8','9'];
        $keys=[];
        for ($i=0;$i<$len;$i++)
        {
            $temp=rand(1,999);
            $value=(int)($temp/100);
            $key="";
            switch ($value)
            {
                case 0:
                case 2:
                    $key=$a_z[rand(0,23)];
                    break;
                case 4:
                case 6:
                case 8:
                    $key=$a_z[rand(0,23)];
                    break;
                case 1:
                case 3:
                    $key=$number[rand(0,7)];
                case 5:
                case 7:
                case 9:
                    $key=$number[rand(0,7)];
                    break;
                default:
                    $key=$number[rand(0,7)];
                    break;
            }
            $keys[]=$key;
        }
        return join("",$keys);
    }
}