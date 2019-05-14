<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-02
 * Time: 10:57
 */
namespace backend\rbac;
use yii\rbac\Rule;
use backend\Models\Menu;

class RoleRule extends Rule{

    public function execute($user,$item,$params)
    {
        return isset($params['index'])?$params['index']->createBy==$user:false;
    }
}