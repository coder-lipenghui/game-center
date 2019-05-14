<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_game_update".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property string $platformId 渠道id，按照“，”分隔
 * @property string $url 资源CDN
 * @property string $version 版本信息
 * @property string $versionfile
 * @property string $assets 版本zip文件名称
 * @property int $size zip文件大小，kb
 * @property string $autotime 自动更新时间
 * @property string $enabled 是否开放下载
 * @property string $svn svn版本号
 */
class TabGameUpdate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_game_update';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'platformId'], 'required'],
            [['gameId', 'size'], 'integer'],
            [['autotime'], 'safe'],
            [['enabled'], 'string'],
            [['platformId', 'url'], 'string', 'max' => 255],
            [['version', 'versionfile', 'assets'], 'string', 'max' => 100],
            [['svn'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gameId' => Yii::t('app', 'Game ID'),
            'platformId' => Yii::t('app', 'Platform ID'),
            'url' => Yii::t('app', 'Url'),
            'version' => Yii::t('app', 'Version'),
            'versionfile' => Yii::t('app', 'Versionfile'),
            'assets' => Yii::t('app', 'Assets'),
            'size' => Yii::t('app', 'Size'),
            'autotime' => Yii::t('app', 'Autotime'),
            'enabled' => Yii::t('app', 'Enabled'),
            'svn' => Yii::t('app', 'Svn'),
        ];
    }
}
