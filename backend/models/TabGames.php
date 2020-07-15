<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_games".
 *
 * @property int $id
 * @property string $name 游戏名称
 * @property string $logo 游戏LOGO
 * @property string $info 游戏描述信息
 * @property string $sku
 * @property int $versionId 游戏版本
 * @property string $loginKey 登录验证KEY
 * @property string $paymentKey 发货验证KEY
 * @property string $createTime 入库时间
 * @property int $mingleGameId 互通游戏ID
 * @property string $copyright_number 新广出审号
 * @property string $copyright_isbn 出版物号
 * @property string $copyright_press 出版社
 * @property string $copyright_author 新广出审号
 */
class TabGames extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_games';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'sku', 'createTime'], 'required'],
            [['info'], 'string'],
            [['versionId', 'mingleGameId'], 'integer'],
            [['createTime'], 'safe'],
            [['name', 'sku'], 'string', 'max' => 45],
            [['logo'], 'string', 'max' => 200],
            [['loginKey', 'paymentKey'], 'string', 'max' => 64],
            [['copyright_number', 'copyright_isbn', 'copyright_press', 'copyright_author'], 'string', 'max' => 100],
            [['sku'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'logo' => Yii::t('app', 'Logo'),
            'info' => Yii::t('app', 'Info'),
            'sku' => Yii::t('app', 'Sku'),
            'versionId' => Yii::t('app', 'Version ID'),
            'loginKey' => Yii::t('app', 'Login Key'),
            'paymentKey' => Yii::t('app', 'Payment Key'),
            'createTime' => Yii::t('app', 'Create Time'),
            'mingleGameId' => Yii::t('app', 'Mingle Game ID'),
            'copyright_number' => Yii::t('app', 'Copyright Number'),
            'copyright_isbn' => Yii::t('app', 'Copyright Isbn'),
            'copyright_press' => Yii::t('app', 'Copyright Press'),
            'copyright_author' => Yii::t('app', 'Copyright Author'),
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabDistributions()
    {
        return $this->hasMany(TabDistribution::className(), ['gameId' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabNotices()
    {
        return $this->hasMany(TabNotice::className(), ['gameId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabPermissions()
    {
        return $this->hasMany(TabPermission::className(), ['gameId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabPlayers()
    {
        return $this->hasMany(TabPlayers::className(), ['gameId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTabServers()
    {
        return $this->hasMany(TabServers::className(), ['gameId' => 'id']);
    }

    public function getVersion()
    {
        return $this->hasOne(TabGameVersion::className(),['id'=>'versionId']);
    }
}
