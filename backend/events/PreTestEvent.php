<?php
namespace backend\events;
use yii\base\Event;
class PreTestEvent extends Event
{
    public $distributionId;
    public $distributionUserId;
    public $account;
    public $gameId;
    public $serverId;
    public $roleId;
    public $roleName;
}