<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_cmd".
 *
 * @property int $id
 * @property int $type 命令类型
 * @property string $name
 * @property string $shortName 中文命令名称
 * @property string $comment 命令介绍
 */
class TabCmd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_cmd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name', 'shortName'], 'required'],
            [['type'], 'integer'],
            [['name', 'shortName', 'comment'], 'string', 'max' => 255],
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
            'name' => Yii::t('app', 'Name'),
            'shortName' => Yii::t('app', 'Short Name'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }
}
