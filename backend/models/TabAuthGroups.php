<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_auth_groups".
 *
 * @property int $id
 * @property string $title
 * @property int $status
 * @property string $rules
 */
class TabAuthGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_auth_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'rules'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['rules'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'status' => Yii::t('app', 'Status'),
            'rules' => Yii::t('app', 'Rules'),
        ];
    }
}
