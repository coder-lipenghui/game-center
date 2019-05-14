<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_ios_release".
 *
 * @property int $id
 * @property string $sku
 * @property int $dist
 * @property string $version
 * @property string $isRelease
 */
class TabIosRelease extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_ios_release';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dist'], 'integer'],
            [['isRelease'], 'string'],
            [['sku'], 'string', 'max' => 50],
            [['version'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sku' => Yii::t('app', 'Sku'),
            'dist' => Yii::t('app', 'Dist'),
            'version' => Yii::t('app', 'Version'),
            'isRelease' => Yii::t('app', 'Is Release'),
        ];
    }
}
