<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_bonus".
 *
 * @property int $id
 * @property int $gameId 游戏ID
 * @property int $distributorId 分销商ID
 * @property int $bindAmount 绑定元宝福利额度
 * @property int $unbindAmount 非绑定元宝福利额度
 * @property int $bindRatio 充值增加绑定福利比例
 * @property int $unbindRatio 充值增加非绑定福利比例
 */
class TabBonus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_bonus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gameId', 'distributorId', 'bindAmount', 'unbindAmount', 'bindRatio', 'unbindRatio'], 'required'],
            [['gameId', 'distributorId', 'bindAmount', 'unbindAmount', 'bindRatio', 'unbindRatio'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'gameId' => Yii::t('app', '游戏'),
            'distributorId' => Yii::t('app', '分销商'),
            'bindAmount' => Yii::t('app', '绑定额度'),
            'unbindAmount' => Yii::t('app', '非绑定额度'),
            'bindRatio' => Yii::t('app', '绑定比例'),
            'unbindRatio' => Yii::t('app', '非绑定比例'),
        ];
    }
}
