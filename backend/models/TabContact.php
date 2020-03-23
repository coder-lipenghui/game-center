<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_contact".
 *
 * @property int $id
 * @property string $activeAccount
 * @property string $activeRoleId
 * @property string $passivityAccount
 * @property string $passivityRoleId
 * @property int $serverId
 * @property int $logTime
 */
class TabContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_contact';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_log');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activeAccount', 'activeRoleId', 'passivityAccount', 'passivityRoleId', 'serverId', 'logTime'], 'required'],
            [['serverId', 'logTime'], 'integer'],
            [['activeAccount', 'activeRoleId', 'passivityAccount', 'passivityRoleId'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'activeAccount' => Yii::t('app', 'Active Account'),
            'activeRoleId' => Yii::t('app', 'Active Role ID'),
            'passivityAccount' => Yii::t('app', 'Passivity Account'),
            'passivityRoleId' => Yii::t('app', 'Passivity Role ID'),
            'serverId' => Yii::t('app', 'Server ID'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
}
