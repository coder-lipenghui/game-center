<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_auth_rules".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property int $type
 * @property int $status
 * @property string $condition
 */
class TabAuthRules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_auth_rules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required'],
            [['type', 'status'], 'integer'],
            [['name'], 'string', 'max' => 80],
            [['title'], 'string', 'max' => 20],
            [['condition'], 'string', 'max' => 100],
            [['name'], 'unique'],
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
            'title' => Yii::t('app', 'Title'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'condition' => Yii::t('app', 'Condition'),
        ];
    }
}
