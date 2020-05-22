<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_system_1".
 *
 * @property int $id
 * @property int $systemId
 * @property string $systemName
 * @property int $parentId
 * @property string $type
 * @property int $denominator
 */
class TabSystem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_system_1';
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
            [['systemId', 'parentId', 'denominator'], 'integer'],
            [['systemName'], 'required'],
            [['systemName'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'systemId' => Yii::t('app', 'System ID'),
            'systemName' => Yii::t('app', 'System Name'),
            'parentId' => Yii::t('app', 'Parent ID'),
            'type' => Yii::t('app', 'Type'),
            'denominator' => Yii::t('app', 'Denominator'),
        ];
    }
}
