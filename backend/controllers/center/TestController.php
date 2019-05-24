<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-24
 * Time: 16:03
 */

namespace backend\controllers\center;


class TestController extends CenterController
{
    public function loginValidate($request, $distribution)
    {
        $player = array(
            'distributionUserId'        => $request['uid'],
            'distributionUserAccount'   => $request['uid'],
            'distributionId'            => $distribution->id,
        );
        return $player;
    }
}