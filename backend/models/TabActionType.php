<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_action_type".
 *
 * @property int $id
 * @property int $actionId 日志编号
 * @property int $actionType 日志类型:增加、移除
 * @property string $actionName 日志名称
 * @property string $actionDesp 日志描述
 * @property string $actionLua lua变量
 */
class TabActionType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_action_type';
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
            'actionId' => Yii::t('app', '方式ID'),
            'actionType' => Yii::t('app', '记录方式'),
            'actionName' => Yii::t('app', '方式名称'),
            'actionDesp' => Yii::t('app', '方式描述'),
            'actionLua' => Yii::t('app', 'Lua变量'),
        ];
    }
}
