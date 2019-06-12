<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-12
 * Time: 11:14
 */

namespace backend\models\center;


class CreateOrderDebug extends CreateOrder
{
    public static function tableName()
    {
        return parent::tableName()."_debug";
    }
}