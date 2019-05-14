<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_log_role".
 *
 * @property int $id
 * @property string $loginKey
 * @property string $token
 * @property string $roleId
 * @property string $roleName
 * @property string $roleLevel
 * @property int $zoneId
 * @property string $zoneName
 * @property int $ctime
 * @property int $distId
 * @property string $sku
 * @property string $createtime
 */
class TabLogRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_log_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zoneId', 'ctime', 'distId'], 'integer'],
            [['createtime'], 'safe'],
            [['loginKey', 'token', 'roleId', 'roleName', 'roleLevel', 'zoneName', 'sku'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'loginKey' => Yii::t('app', 'Login Key'),
            'token' => Yii::t('app', 'Token'),
            'roleId' => Yii::t('app', 'Role ID'),
            'roleName' => Yii::t('app', 'Role Name'),
            'roleLevel' => Yii::t('app', 'Role Level'),
            'zoneId' => Yii::t('app', 'Zone ID'),
            'zoneName' => Yii::t('app', 'Zone Name'),
            'ctime' => Yii::t('app', 'Ctime'),
            'distId' => Yii::t('app', 'Dist ID'),
            'sku' => Yii::t('app', 'Sku'),
            'createtime' => Yii::t('app', 'Createtime'),
        ];
    }
}
