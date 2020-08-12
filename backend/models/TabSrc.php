<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_src_2".
 *
 * @property int $id
 * @property int $actionId 日志编号
 * @property int $actionType 日志类型:增加、移除
 * @property string $actionName 日志名称
 * @property string $actionDesp 日志描述
 * @property string $actionLua lua变量
 */
class TabSrc extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_src';
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
            [['actionId', 'actionType'], 'integer'],
            [['actionName', 'actionDesp', 'actionLua'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'actionId' => Yii::t('app', 'Action ID'),
            'actionType' => Yii::t('app', 'Action Type'),
            'actionName' => Yii::t('app', 'Action Name'),
            'actionDesp' => Yii::t('app', 'Action Desp'),
            'actionLua' => Yii::t('app', 'Action Lua'),
        ];
    }
}
