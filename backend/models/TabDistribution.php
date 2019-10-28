<?php

namespace backend\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "tab_distribution".
 *
 * @property int $id
 * @property int $gameId 游戏id
 * @property string $platform 设备:android、ios
 * @property int $distributorId 分销商ID
 * @property int $parentDT 父级代理,该字段有值则代表该渠道为二级分销商
 * @property string $centerLoginKey 中控登录KEY
 * @property string $centerPaymentKey 中控获取订单KEY
 * @property string $appID 分销商分配的游戏ID
 * @property string $appKey 分销商分配的游戏KEY
 * @property string $appLoginKey 分销商分配的登录KEY
 * @property string $appPaymentKey 分销商提供的充值KEY
 * @property string $appPublicKey RSA等key
 * @property int $ratio 充值获取元宝比例 默认1:100
 * @property int $support 默认扶持金额
 * @property int $enabled 该分销渠道是否启用
 * @property int $isDebug 是否已经上线
 * @property string $api 登录、充值验证接口
 *
 * @property TabDistributor $distributor
 * @property TabGames $game
 * @property TabNotice[] $tabNotices
 * @property TabServers[] $tabServers
 */
class TabDistribution extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_distribution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributorId', 'enabled'], 'required'],
            [['gameId', 'distributorId', 'parentDT','ratio','support','enabled', 'isDebug'], 'integer'],
            [['platform'], 'string', 'max' => 50],
            [['centerLoginKey', 'centerPaymentKey'], 'string', 'max' => 32],
            [['appID', 'appKey', 'appLoginKey', 'appPaymentKey', 'appPublicKey'], 'string', 'max' => 255],
            [['api'], 'string', 'max' => 100],
            [['distributorId'], 'exist', 'skipOnError' => true, 'targetClass' => TabDistributor::className(), 'targetAttribute' => ['distributorId' => 'id']],
            [['gameId'], 'exist', 'skipOnError' => true, 'targetClass' => TabGames::className(), 'targetAttribute' => ['gameId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', '分销ID'),
            'gameId' => Yii::t('app', '游戏名称'),
            'platform' => Yii::t('app', '设备平台'),
            'distributorId' => Yii::t('app', '所属分销商'),
            'parentDT' => Yii::t('app', '父级分销商'),
            'centerLoginKey' => Yii::t('app', '我方登录KEY'),
            'centerPaymentKey' => Yii::t('app', '我方订单KEY'),
            'appID' => Yii::t('app', '分销APPID'),
            'appKey' => Yii::t('app', '分销APPKEY'),
            'appLoginKey' => Yii::t('app', '分销登录KEY'),
            'appPaymentKey' => Yii::t('app', '分销充值KEY'),
            'appPublicKey' => Yii::t('app', '分销充值KEY2'),
            'ratio'=>Yii::t('app','充值比例'),
            'support'=>Yii::t('app','扶持金额'),
            'enabled' => Yii::t('app', '是否可用'),
            'isDebug' => Yii::t('app', '正在调试'),
            'api' => Yii::t('app', 'SDK名'),
        ];
    }

    /**
     * 创建日志表：cdkey、角色表、账号表等
     * @param $gameId
     * @param $distributionId
     */
    public function createLogTables($gameId,$distributorId)
    {
        //cdkey表
        try{
            $query=Yii::$app->get('db_log')->createCommand("
                DROP TABLE IF EXISTS `tab_cdkey_".$gameId."_".$distributorId."`;
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
            ");
            $query->execute();
            $query->pdoStatement->closeCursor();
            //创角日志
            $query=Yii::$app->get('db_log')->createCommand("
                DROP TABLE IF EXISTS `tab_log_role_".$gameId."_".$distributorId."`;
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
            ");
            $query->execute();
            $query->pdoStatement->closeCursor();
            //升级日志
            $query2=Yii::$app->get('db_log')->createCommand("
                DROP TABLE IF EXISTS `tab_log_level_".$gameId."_".$distributorId."`;
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
            ");
            $query->execute();
            //登录日志
            $query=Yii::$app->get('db_log')->createCommand("
                DROP TABLE IF EXISTS `tab_log_login_".$gameId."_".$distributorId."`;
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
            ");
            $query->execute();
            $query->pdoStatement->closeCursor();
            //启动游戏
            $query=Yii::$app->get('db_log')->createCommand("
                DROP TABLE IF EXISTS `tab_log_start_".$gameId."_".$distributorId."`;
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
            ");
            $query->execute();
            $query->pdoStatement->closeCursor();
        }catch (Exception $exception)
        {
            exit($exception->getMessage());
        }

        //日志表

        //角色表
        //
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
