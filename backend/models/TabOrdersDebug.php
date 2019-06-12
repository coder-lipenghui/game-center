<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-06-12
 * Time: 11:23
 */

namespace backend\models;


class TabOrdersDebug extends TabOrders
{
    public static function tableName()
    {
        return parent::tableName()."_debug";
    }
}