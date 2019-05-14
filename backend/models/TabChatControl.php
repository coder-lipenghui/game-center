<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_chat_control".
 *
 * @property int $id
 * @property string $userName
 * @property string $userPwd
 * @property string $userPTFlag
 * @property int $isManager
 */
class TabChatControl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_chat_control';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userName', 'userPwd', 'userPTFlag'], 'required'],
            [['isManager'], 'integer'],
            [['userName', 'userPwd', 'userPTFlag'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userName' => Yii::t('app', 'User Name'),
            'userPwd' => Yii::t('app', 'User Pwd'),
            'userPTFlag' => Yii::t('app', 'User Pt Flag'),
            'isManager' => Yii::t('app', 'Is Manager'),
        ];
    }
}
