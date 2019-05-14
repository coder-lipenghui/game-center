<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_auth_group_access".
 *
 * @property int $uid
 * @property int $group_id
 */
class TabAuthGroupAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_auth_group_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'group_id'], 'required'],
            [['uid', 'group_id'], 'integer'],
            [['uid', 'group_id'], 'unique', 'targetAttribute' => ['uid', 'group_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => Yii::t('app', 'Uid'),
            'group_id' => Yii::t('app', 'Group ID'),
        ];
    }
}
