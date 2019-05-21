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
 * @property string $loginKey 登录验证KEY
 * @property string $paymentKey 发货验证KEY
 * @property string $createTime 入库时间
 * @property string $copyright_number 新广出审号
 * @property string $copyright_isbn 出版物号
 * @property string $copyright_press 出版社
 * @property string $copyright_author 新广出审号
 *
 * @property TabDistribution[] $tabDistributions
 * @property TabNotice[] $tabNotices
 * @property TabPermission[] $tabPermissions
 * @property TabPlayers[] $tabPlayers
 * @property TabServers[] $tabServers
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
            [['name', 'sku', 'createTime','loginKey','paymentKey'], 'required'],
            [['info'], 'string'],
            [['createTime'], 'safe'],
            [['name', 'sku'], 'string', 'max' => 45],
            [['name', 'sku'], 'string', 'max' => 45],
            [['loginKey','paymentKey'], 'string', 'max' => 64],
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
            'name' => Yii::t('app', '名称'),
            'logo' => Yii::t('app', 'LOGO'),
            'info' => Yii::t('app', '描述'),
            'sku' => Yii::t('app', 'Sku'),
            'loginKey'=>Yii::t('app', '登录验证KEY'),
            'paymentKey'=>Yii::t('app', '发货验证KEY'),
            'createTime' => Yii::t('app', '创建时间'),
            'copyright_number' => Yii::t('app', '新广审号'),
            'copyright_isbn' => Yii::t('app', 'ISBN'),
            'copyright_press' => Yii::t('app', '出版单位'),
            'copyright_author' => Yii::t('app', '版权所属'),
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
}
