<?php


namespace backend\models;


use Yii;
use yii\db\Exception;

class MyTabDistribution extends TabDistribution
{

    /**
     * 创建日志表：cdkey、角色表、账号表等
     * @param $gameId
     * @param $distributionId
     */
    public function createLogTables($gameId,$distributorId)
    {
        try{
            //启动游戏
            $this->createTable($this->getStartLogSql($gameId,$distributorId));

            //cdkey表
            $this->createTable($this->getCdkLogSql($gameId,$distributorId));

            //创角日志
            $this->createTable($this->getRoleLogSql($gameId,$distributorId));

            //升级日志
            $this->createTable($this->getLevelLogSql($gameId,$distributorId));

            //登录日志
            $this->createTable($this->getLoginLogSql($gameId,$distributorId));

            //用户返利表
            $this->createTable($this->getContactLogSql($gameId,$distributorId));

            //问题反馈表
            $this->createTable($this->getFeedbackLogSql($gameId,$distributorId));

        }catch (Exception $exception)
        {
            exit($exception->getMessage());
        }
    }
    private function createTable($sql)
    {
        $query=Yii::$app->get('db_log')->createCommand($sql);
        $query->execute();
        $query->pdoStatement->closeCursor();
    }

    /**
     * 好友返利日志表
     * @param $gameId
     * @param $distributorId
     * @return string
     */
    private function getContactLogSql($gameId,$distributorId)
    {
        return "DROP TABLE IF EXISTS `tab_contact_".$gameId."_".$distributorId."`;
                CREATE TABLE `tab_contact_".$gameId."_".$distributorId."`(
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `activeAccount` varchar(255) NOT NULL,
                  `activeRoleId` varchar(255) NOT NULL,
                  `passivityAccount` varchar(255) NOT NULL,
                  `passivityRoleId` varchar(255) NOT NULL,
                  `serverId` int(11) NOT NULL,
                  `logTime` int(10) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                SET FOREIGN_KEY_CHECKS = 1;";
    }

    /**
     * 问题反馈日志表
     * @param $gameId
     * @param $distributorId
     * @return string
     */
    private function getFeedbackLogSql($gameId,$distributorId)
    {
        return "
                DROP TABLE IF EXISTS `tab_feedback_".$gameId."_".$distributorId."`;
                CREATE TABLE `tab_feedback_".$gameId."_".$distributorId."` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `gameId` int(11) NOT NULL COMMENT '游戏ID',
                  `distributorId` int(11) NOT NULL COMMENT '分销商ID',
                  `distributionId` int(11) NOT NULL COMMENT '分销渠道ID',
                  `serverId` int(11) NOT NULL COMMENT '区ID',
                  `account` varchar(255) NOT NULL COMMENT '账号',
                  `roleId` varchar(200) NOT NULL COMMENT '角色ID',
                  `roleName` varchar(255) NOT NULL COMMENT '角色名',
                  `title` varchar(255) NOT NULL COMMENT '反馈标题',
                  `content` varchar(255) NOT NULL COMMENT '反馈内容',
                  `state` int(10) NOT NULL DEFAULT '0' COMMENT '已读、已回复、暂不处理',
                  PRIMARY KEY (`id`) USING BTREE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
                SET FOREIGN_KEY_CHECKS = 1;
            ";
    }
    /**
     * 游戏启动日志表
     * @param $gameId
     * @param $distributorId
     * @return string
     */
    private function getStartLogSql($gameId,$distributorId)
    {
        return "DROP TABLE IF EXISTS `tab_log_start_".$gameId."_".$distributorId."`;
                CREATE TABLE `tab_log_start_".$gameId."_".$distributorId."`(
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `ip` varchar(255) NOT NULL,
                  `deviceId` varchar(255) NOT NULL,
                  `deviceOs` varchar(255) NOT NULL,
                  `deviceName` varchar(255) DEFAULT NULL,
                  `deviceVender` varchar(255) NOT NULL,
                  `logTime` int(10) NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                
                SET FOREIGN_KEY_CHECKS = 1;
            ";
    }
    /**
     * 登录日志表
     * @param $gameId
     * @param $distributorId
     * @return string
     */
    private function getLoginLogSql($gameId,$distributorId)
    {
        return "DROP TABLE IF EXISTS `tab_log_login_".$gameId."_".$distributorId."`;
                CREATE TABLE `tab_log_login_".$gameId."_".$distributorId."`(
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `account` varchar(255) NOT NULL COMMENT '中控用户ID',
                  `distributionUserId` varchar(255) NOT NULL COMMENT '渠道用户ID',
                  `gameId` int(11) NOT NULL COMMENT '游戏ID',
                  `distributionId` int(11) NOT NULL COMMENT '渠道ID',
                  `serverId` int(11) NOT NULL COMMENT '区服ID',
                  `roleId` varchar(255) NOT NULL COMMENT '角色ID',
                  `roleName` varchar(255) NOT NULL COMMENT '角色名称',
                  `roleLevel` int(11) NOT NULL COMMENT '角色等级',
                  `deviceVender` varchar(255) NOT NULL COMMENT '设备厂商',
                  `deviceOs` varchar(255) NOT NULL COMMENT '设备系统',
                  `deviceId` varchar(255) NOT NULL COMMENT '设备ID',
                  `logTime` int(10) NOT NULL COMMENT '记录时间',
                  PRIMARY KEY (`id`) USING BTREE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                
                SET FOREIGN_KEY_CHECKS = 1;
            ";
    }
    /**
     * CDK表
     * @param $gameId
     * @param $distributorId
     * @return string
     */
    private function getCdkLogSql($gameId,$distributorId)
    {
        return "DROP TABLE IF EXISTS `tab_cdkey_".$gameId."_".$distributorId."`;
                CREATE TABLE `tab_cdkey_".$gameId."_".$distributorId."` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `gameId` int(10) NOT NULL COMMENT '游戏ID',
                  `distributorId` int(10) NOT NULL COMMENT '分销商ID',
                  `distributionId` int(10) DEFAULT NULL COMMENT '分销渠道ID',
                  `varietyId` int(11) NOT NULL COMMENT '激活码分类ID',
                  `cdkey` varchar(100) NOT NULL COMMENT '激活码',
                  `used` int(2) NOT NULL DEFAULT '0' COMMENT '是否使用：0未使用 1:使用过',
                  `createTime` int(10) NOT NULL COMMENT '创建时间',
                  PRIMARY KEY (`id`),
                  KEY `key_variety` (`varietyId`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
            ";
    }

    /**
     * 角色升级日志表
     * @param $gameId
     * @param $distributorId
     * @return string
     */
    private function getLevelLogSql($gameId,$distributorId)
    {
        return "DROP TABLE IF EXISTS `tab_log_level_".$gameId."_".$distributorId."`;
                CREATE TABLE `tab_log_level_".$gameId."_".$distributorId."`(
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `account` varchar(255) NOT NULL COMMENT '中控用户ID',
                  `distributionUserId` varchar(255) NOT NULL COMMENT '渠道用户ID',
                  `gameId` int(11) NOT NULL COMMENT '游戏ID',
                  `distributionId` int(11) NOT NULL COMMENT '渠道ID',
                  `serverId` int(11) NOT NULL COMMENT '区服ID',
                  `roleId` varchar(255) NOT NULL COMMENT '角色ID',
                  `roleName` varchar(255) NOT NULL COMMENT '角色名称',
                  `roleLevel` int(10) NOT NULL COMMENT '角色等级',
                  `updateTime` int(10) NOT NULL COMMENT '升级时间',
                  `logTime` int(10) NOT NULL COMMENT '记录时间',
                  PRIMARY KEY (`id`) USING BTREE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                SET FOREIGN_KEY_CHECKS = 1;
            ";
    }
    /**
     * 创角日志表
     * @param $gameId
     * @param $distributorId
     * @return string
     */
    private function getRoleLogSql($gameId,$distributorId)
    {
        return "DROP TABLE IF EXISTS `tab_log_role_".$gameId."_".$distributorId."`;
                CREATE TABLE `tab_log_role_".$gameId."_".$distributorId."`(
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `distributionUserId` varchar(255) NOT NULL COMMENT '渠道用户ID',
                  `account` varchar(255) NOT NULL COMMENT '中控分配的账号',
                  `gameId` int(11) NOT NULL COMMENT '游戏ID',
                  `distributionId` int(11) NOT NULL COMMENT '渠道ID',
                  `serverId` int(11) NOT NULL COMMENT '区服ID',
                  `roleId` varchar(255) NOT NULL COMMENT '角色唯一ID',
                  `roleName` varchar(255) NOT NULL COMMENT '角色名称',
                  `createTime` int(10) NOT NULL COMMENT '角色创建时间',
                  `logTime` int(10) NOT NULL COMMENT '记录时间',
                  PRIMARY KEY (`id`) USING BTREE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                
                SET FOREIGN_KEY_CHECKS = 1;
            ";
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributor()
    {
        return $this->hasOne(TabDistributor::className(), ['id' => 'distributorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(TabGames::className(), ['id' => 'gameId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabNotices()
    {
        return $this->hasMany(TabNotice::className(), ['distributionId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabServers()
    {
        return $this->hasMany(TabServers::className(), ['distributionId' => 'id']);
    }
}