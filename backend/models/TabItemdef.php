<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_itemdef".
 *
 * @property int $id 物品id
 * @property int $sub_type 物品分类
 * @property int $res_id 资源id
 * @property int $icon_id 图标id
 * @property string $script 出发脚本
 * @property string $name 物品名称
 * @property string $shape
 * @property int $weight 重量
 * @property int $diejia 叠加
 * @property int $zhanli 战力
 * @property int $last_time last_time
 * @property int $giftid 礼包id
 * @property int $duramax duramax
 * @property int $notips 没有tips
 * @property int $protect 保护
 * @property int $ac 物防
 * @property int $ac2 ac2
 * @property int $mac mac
 * @property int $mac2 mac2
 * @property int $dc dc
 * @property int $dc2 dc2
 * @property int $mc mc
 * @property int $mc2 mc2
 * @property int $sc sc
 * @property int $sc2 sc2
 * @property int $luck 幸运
 * @property int $unluck 诅咒
 * @property int $hit 命中
 * @property int $shanbi 闪避
 * @property int $shanbi_mf 魔法闪避
 * @property int $shanbi_zd 中毒闪避
 * @property int $HPhuifu HP恢复
 * @property int $MPhuifu MP恢复
 * @property int $fabaoparam 法宝参数
 * @property int $baojijilv 暴击几率
 * @property int $baojibaifenbi 暴击百分比
 * @property int $baojijiacheng 暴击加成
 * @property int $needlevel needlevel
 * @property int $price 价格
 * @property int $rand_range rand_range
 * @property int $rand_ac rand_ac
 * @property int $rand_mac rand_mac
 * @property int $rand_dc rand_dc
 * @property int $rand_mc rand_mc
 * @property int $rand_sc rand_sc
 * @property int $add_base_ac 基础xx增加
 * @property int $add_base_mac 基础魔防增加
 * @property int $add_base_dc 基础物攻增加
 * @property int $add_base_mc 基础魔攻增加
 * @property int $add_base_sc 基础道攻增加
 * @property int $max_hp 最大血量
 * @property int $max_mp 最大蓝量
 * @property int $max_hp_pres 最大X血比例
 * @property int $max_mp_pres 最大X蓝比例
 * @property int $needZLv 转生等级需求
 * @property int $needLv 等级需求
 * @property int $needJob 职业需求
 * @property int $needGender 性别需求
 * @property int $compare 装备对比
 * @property int $gongxian 贡献值
 * @property int $destroyMsg 销毁提示
 * @property int $neigong 内功
 * @property int $background 背景
 * @property int $huishoujifen 回收返还积分数
 * @property int $huishoujinbi 回收返还金币数
 * @property int $huishouyuanbao 回收返还元宝数
 * @property string $description 物品描述
 */
class TabItemdef extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_itemdef';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'sub_type', 'res_id', 'icon_id', 'weight', 'diejia', 'zhanli', 'last_time', 'giftid', 'duramax', 'notips', 'protect', 'ac', 'ac2', 'mac', 'mac2', 'dc', 'dc2', 'mc', 'mc2', 'sc', 'sc2', 'luck', 'unluck', 'hit', 'shanbi', 'shanbi_mf', 'shanbi_zd', 'HPhuifu', 'MPhuifu', 'fabaoparam', 'baojijilv', 'baojibaifenbi', 'baojijiacheng', 'needlevel', 'price', 'rand_range', 'rand_ac', 'rand_mac', 'rand_dc', 'rand_mc', 'rand_sc', 'add_base_ac', 'add_base_mac', 'add_base_dc', 'add_base_mc', 'add_base_sc', 'max_hp', 'max_mp', 'max_hp_pres', 'max_mp_pres', 'needZLv', 'needLv', 'needJob', 'needGender', 'compare', 'gongxian', 'destroyMsg', 'neigong', 'background', 'huishoujifen', 'huishoujinbi', 'huishouyuanbao'], 'integer'],
            [['script'], 'string', 'max' => 50],
            [['name', 'shape'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sub_type' => Yii::t('app', 'Sub Type'),
            'res_id' => Yii::t('app', 'Res ID'),
            'icon_id' => Yii::t('app', 'Icon ID'),
            'script' => Yii::t('app', 'Script'),
            'name' => Yii::t('app', 'Name'),
            'shape' => Yii::t('app', 'Shape'),
            'weight' => Yii::t('app', 'Weight'),
            'diejia' => Yii::t('app', 'Diejia'),
            'zhanli' => Yii::t('app', 'Zhanli'),
            'last_time' => Yii::t('app', 'Last Time'),
            'giftid' => Yii::t('app', 'Giftid'),
            'duramax' => Yii::t('app', 'Duramax'),
            'notips' => Yii::t('app', 'Notips'),
            'protect' => Yii::t('app', 'Protect'),
            'ac' => Yii::t('app', 'Ac'),
            'ac2' => Yii::t('app', 'Ac2'),
            'mac' => Yii::t('app', 'Mac'),
            'mac2' => Yii::t('app', 'Mac2'),
            'dc' => Yii::t('app', 'Dc'),
            'dc2' => Yii::t('app', 'Dc2'),
            'mc' => Yii::t('app', 'Mc'),
            'mc2' => Yii::t('app', 'Mc2'),
            'sc' => Yii::t('app', 'Sc'),
            'sc2' => Yii::t('app', 'Sc2'),
            'luck' => Yii::t('app', 'Luck'),
            'unluck' => Yii::t('app', 'Unluck'),
            'hit' => Yii::t('app', 'Hit'),
            'shanbi' => Yii::t('app', 'Shanbi'),
            'shanbi_mf' => Yii::t('app', 'Shanbi Mf'),
            'shanbi_zd' => Yii::t('app', 'Shanbi Zd'),
            'HPhuifu' => Yii::t('app', 'H Phuifu'),
            'MPhuifu' => Yii::t('app', 'M Phuifu'),
            'fabaoparam' => Yii::t('app', 'Fabaoparam'),
            'baojijilv' => Yii::t('app', 'Baojijilv'),
            'baojibaifenbi' => Yii::t('app', 'Baojibaifenbi'),
            'baojijiacheng' => Yii::t('app', 'Baojijiacheng'),
            'needlevel' => Yii::t('app', 'Needlevel'),
            'price' => Yii::t('app', 'Price'),
            'rand_range' => Yii::t('app', 'Rand Range'),
            'rand_ac' => Yii::t('app', 'Rand Ac'),
            'rand_mac' => Yii::t('app', 'Rand Mac'),
            'rand_dc' => Yii::t('app', 'Rand Dc'),
            'rand_mc' => Yii::t('app', 'Rand Mc'),
            'rand_sc' => Yii::t('app', 'Rand Sc'),
            'add_base_ac' => Yii::t('app', 'Add Base Ac'),
            'add_base_mac' => Yii::t('app', 'Add Base Mac'),
            'add_base_dc' => Yii::t('app', 'Add Base Dc'),
            'add_base_mc' => Yii::t('app', 'Add Base Mc'),
            'add_base_sc' => Yii::t('app', 'Add Base Sc'),
            'max_hp' => Yii::t('app', 'Max Hp'),
            'max_mp' => Yii::t('app', 'Max Mp'),
            'max_hp_pres' => Yii::t('app', 'Max Hp Pres'),
            'max_mp_pres' => Yii::t('app', 'Max Mp Pres'),
            'needZLv' => Yii::t('app', 'Need Z Lv'),
            'needLv' => Yii::t('app', 'Need Lv'),
            'needJob' => Yii::t('app', 'Need Job'),
            'needGender' => Yii::t('app', 'Need Gender'),
            'compare' => Yii::t('app', 'Compare'),
            'gongxian' => Yii::t('app', 'Gongxian'),
            'destroyMsg' => Yii::t('app', 'Destroy Msg'),
            'neigong' => Yii::t('app', 'Neigong'),
            'background' => Yii::t('app', 'Background'),
            'huishoujifen' => Yii::t('app', 'Huishoujifen'),
            'huishoujinbi' => Yii::t('app', 'Huishoujinbi'),
            'huishouyuanbao' => Yii::t('app', 'Huishouyuanbao'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
