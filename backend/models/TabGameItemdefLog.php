<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_game_itemdef_log".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property string $version itemdef版本号
 * @property int $logTime 上传时间
 */
class TabGameItemdefLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_game_itemdef_log';
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
            [['gameId', 'version'], 'required'],
            [['gameId'], 'integer'],
            [['logTime'],'filter','filter'=>function(){
                return strtotime($this->logTime);
            }],
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
            'gameId' => Yii::t('app', 'Game ID'),
            'version' => Yii::t('app', 'Version'),
            'logTime' => Yii::t('app', 'Log Time'),
        ];
    }
}
