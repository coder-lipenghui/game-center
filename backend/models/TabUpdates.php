<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_updates".
 *
 * @property int $id
 * @property string $type 1:是资源+部分活动脚本热更新,2:是apk版本更新
 * @property string $url 资源更新地址
 * @property int $gameid 游戏ID
 * @property int $platformid 渠道ID
 * @property string $version
 * @property string $filename 资源文件名(zip格式)
 * @property string $libversion LIB版本号
 * @property string $libfilename LIB件名(zip格式)
 * @property string $packageversion
 * @property string $packagefilename
 * @property string $update_time
 * @property string $SVN_version 版本号
 */
class TabUpdates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_updates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'gameid'], 'required'],
            [['gameid', 'platformid'], 'integer'],
            [['update_time'], 'safe'],
            [['type', 'libversion', 'packageversion', 'SVN_version'], 'string', 'max' => 45],
            [['url', 'version', 'filename', 'libfilename', 'packagefilename'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'url' => Yii::t('app', 'Url'),
            'gameid' => Yii::t('app', 'Gameid'),
            'platformid' => Yii::t('app', 'Platformid'),
            'version' => Yii::t('app', 'Version'),
            'filename' => Yii::t('app', 'Filename'),
            'libversion' => Yii::t('app', 'Libversion'),
            'libfilename' => Yii::t('app', 'Libfilename'),
            'packageversion' => Yii::t('app', 'Packageversion'),
            'packagefilename' => Yii::t('app', 'Packagefilename'),
            'update_time' => Yii::t('app', 'Update Time'),
            'SVN_version' => Yii::t('app', 'Svn Version'),
        ];
    }
}
