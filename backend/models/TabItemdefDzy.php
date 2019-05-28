<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tab_itemdef_dzy".
 *
 * @property int $id 物品id
 * @property int $wear_pos 穿戴位置
 * @property int $sub_type 物品分类
 * @property int $res_id 资源ID
 * @property int $icon_id 图标ID
 * @property string $script 出发脚本
 * @property string $name 物品名称
 * @property string $color 物品颜色
 * @property int $weight 物品重量
 * @property int $stackmax 叠加数量
 * @property int $job 职业
 * @property int $gender 性别
 * @property int $needlevel 等级需求
 * @property int $needzslv 转生需求
 * @property int $equip_lv 装备阶数
 * @property int $fightpoint 战力
 * @property int $last_time 持续时间
 * @property int $gift_id 礼包ID
 * @property int $duramax 可用次数
 * @property int $flags 特殊标志
 * @property int $pinzhi 物品品质
 * @property int $protect 原掉落保护
 * @property int $drop_luck 掉落守护
 * @property int $ac 物防
 * @property int $ac2 最大物防
 * @property int $mac 魔防
 * @property int $mac2 最大魔防
 * @property int $dc 物攻
 * @property int $dc2 最大物攻
 * @property int $mc 魔攻
 * @property int $mc2 最大魔攻
 * @property int $sc 道攻
 * @property int $sc2 最大道攻
 * @property int $max_hp 生命上限
 * @property int $max_mp 魔法上限
 * @property int $max_hp_pres 生命加成
 * @property int $max_mp_pres 魔法加成
 * @property int $luck 幸运
 * @property int $curse 诅咒
 * @property int $accuracy 准确
 * @property int $dodge 闪避
 * @property int $anti_magic 魔法闪避
 * @property int $anti_poison 中毒闪避
 * @property int $hp_recover 生命恢复
 * @property int $mp_recover 魔法恢复
 * @property int $poison_recover 中毒恢复
 * @property int $price 价格
 * @property int $mabi_prob 麻痹几率(万分比)
 * @property int $mabi_dura 麻痹时长(毫秒)
 * @property int $anti_mabi 麻痹闪避
 * @property int $frozen_prob 冰冻几率(万分比)
 * @property int $frozen_dura 冰冻时长(毫秒)
 * @property int $relive_prob 复活几率
 * @property int $relive_pres 复活血量加成
 * @property int $relive_cd 复活冷却CD
 * @property int $anti_relive 破复活几率
 * @property int $pveqiege_prob PVE切割几率
 * @property int $pveqiege_pres PVE切割加成
 * @property int $pvpqiege_prob PVP切割几率
 * @property int $pvpqiege_pres PVP切割加成
 * @property int $xixue_prob 吸血几率
 * @property int $xixue_pres 吸血加成
 * @property int $baoji_prob 暴击几率
 * @property int $baojipvp_pres PVP暴击几率
 * @property int $baojipve_pres PVE暴击几率
 * @property int $baoji_point 暴击伤害
 * @property int $baojipvp_point PVP暴击伤害
 * @property int $baojipve_point PVE暴击伤害
 * @property int $anti_baoji 防爆击率
 * @property int $shouhu_pres 守护加成
 * @property int $attack_pres 攻击加成
 * @property int $defense_pres 防御加成
 * @property int $addharm_pres 伤害加成
 * @property int $pvpharm_pres PVP伤害加成
 * @property int $pveharm_pres PVE伤害加成
 * @property int $subharm_pres 减伤加成
 * @property int $atkspd_pres 攻速加成
 * @property int $hetitime_pres 合体时间加成
 * @property int $heticd_pres 合体减CD加成
 * @property int $real_harm 真实伤害
 * @property int $drop_pres 杀怪爆率加成
 * @property int $equip_comp 装备对比
 * @property int $contribute 装备贡献
 * @property int $huishou_exp 回收积分
 * @property int $huishou_jinbi 回收金币
 * @property int $huishou_vcoin 回收元宝
 * @property string $description 物品描述
 */
class TabItemdefDzy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab_itemdef_dzy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'wear_pos', 'sub_type', 'res_id', 'icon_id', 'weight', 'stackmax', 'job', 'gender', 'needlevel', 'needzslv', 'equip_lv', 'fightpoint', 'last_time', 'gift_id', 'duramax', 'flags', 'pinzhi', 'protect', 'drop_luck', 'ac', 'ac2', 'mac', 'mac2', 'dc', 'dc2', 'mc', 'mc2', 'sc', 'sc2', 'max_hp', 'max_mp', 'max_hp_pres', 'max_mp_pres', 'luck', 'curse', 'accuracy', 'dodge', 'anti_magic', 'anti_poison', 'hp_recover', 'mp_recover', 'poison_recover', 'price', 'mabi_prob', 'mabi_dura', 'anti_mabi', 'frozen_prob', 'frozen_dura', 'relive_prob', 'relive_pres', 'relive_cd', 'anti_relive', 'pveqiege_prob', 'pveqiege_pres', 'pvpqiege_prob', 'pvpqiege_pres', 'xixue_prob', 'xixue_pres', 'baoji_prob', 'baojipvp_pres', 'baojipve_pres', 'baoji_point', 'baojipvp_point', 'baojipve_point', 'anti_baoji', 'shouhu_pres', 'attack_pres', 'defense_pres', 'addharm_pres', 'pvpharm_pres', 'pveharm_pres', 'subharm_pres', 'atkspd_pres', 'hetitime_pres', 'heticd_pres', 'real_harm', 'drop_pres', 'equip_comp', 'contribute', 'huishou_exp', 'huishou_jinbi', 'huishou_vcoin'], 'required'],
            [['id', 'wear_pos', 'sub_type', 'res_id', 'icon_id', 'weight', 'stackmax', 'job', 'gender', 'needlevel', 'needzslv', 'equip_lv', 'fightpoint', 'last_time', 'gift_id', 'duramax', 'flags', 'pinzhi', 'protect', 'drop_luck', 'ac', 'ac2', 'mac', 'mac2', 'dc', 'dc2', 'mc', 'mc2', 'sc', 'sc2', 'max_hp', 'max_mp', 'max_hp_pres', 'max_mp_pres', 'luck', 'curse', 'accuracy', 'dodge', 'anti_magic', 'anti_poison', 'hp_recover', 'mp_recover', 'poison_recover', 'price', 'mabi_prob', 'mabi_dura', 'anti_mabi', 'frozen_prob', 'frozen_dura', 'relive_prob', 'relive_pres', 'relive_cd', 'anti_relive', 'pveqiege_prob', 'pveqiege_pres', 'pvpqiege_prob', 'pvpqiege_pres', 'xixue_prob', 'xixue_pres', 'baoji_prob', 'baojipvp_pres', 'baojipve_pres', 'baoji_point', 'baojipvp_point', 'baojipve_point', 'anti_baoji', 'shouhu_pres', 'attack_pres', 'defense_pres', 'addharm_pres', 'pvpharm_pres', 'pveharm_pres', 'subharm_pres', 'atkspd_pres', 'hetitime_pres', 'heticd_pres', 'real_harm', 'drop_pres', 'equip_comp', 'contribute', 'huishou_exp', 'huishou_jinbi', 'huishou_vcoin'], 'integer'],
            [['script'], 'string', 'max' => 100],
            [['name', 'color'], 'string', 'max' => 60],
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
            'id' => Yii::t('app', '物品ID'),
            'wear_pos' => Yii::t('app', '穿戴位置'),
            'sub_type' => Yii::t('app', '物品分类'),
            'res_id' => Yii::t('app', '资源ID'),
            'icon_id' => Yii::t('app', '图标ID'),
            'script' => Yii::t('app', '触发脚本'),
            'name' => Yii::t('app', '物品名称'),
            'color' => Yii::t('app', '物品颜色'),
            'weight' => Yii::t('app', '物品重量'),
            'stackmax' => Yii::t('app', '叠加数量'),
            'job' => Yii::t('app', '职业'),
            'gender' => Yii::t('app', '性别'),
            'needlevel' => Yii::t('app', '等级需求'),
            'needzslv' => Yii::t('app', '转生需求'),
            'equip_lv' => Yii::t('app', '装备阶数'),
            'fightpoint' => Yii::t('app', '战力'),
            'last_time' => Yii::t('app', '持续时间'),
            'gift_id' => Yii::t('app', '礼包ID'),
            'duramax' => Yii::t('app', '可用次数'),
            'flags' => Yii::t('app', '特殊标志'),
            'pinzhi' => Yii::t('app', '物品品质'),
            'protect' => Yii::t('app', '原掉落保护'),
            'drop_luck' => Yii::t('app', '掉落守护'),
            'ac' => Yii::t('app', '物防'),
            'ac2' => Yii::t('app', '最大物防'),
            'mac' => Yii::t('app', '魔防'),
            'mac2' => Yii::t('app', '最大魔防'),
            'dc' => Yii::t('app', '物攻'),
            'dc2' => Yii::t('app', '最大物攻'),
            'mc' => Yii::t('app', '魔攻'),
            'mc2' => Yii::t('app', '最大魔攻'),
            'sc' => Yii::t('app', '道攻'),
            'sc2' => Yii::t('app', '最大道攻'),
            'max_hp' => Yii::t('app', '生命上限'),
            'max_mp' => Yii::t('app', '魔法上限'),
            'max_hp_pres' => Yii::t('app', '生命加成'),
            'max_mp_pres' => Yii::t('app', '魔法加成'),
            'luck' => Yii::t('app', '幸运'),
            'curse' => Yii::t('app', '诅咒'),
            'accuracy' => Yii::t('app', '准确'),
            'dodge' => Yii::t('app', '闪避'),
            'anti_magic' => Yii::t('app', '魔法闪避'),
            'anti_poison' => Yii::t('app', '中毒闪避'),
            'hp_recover' => Yii::t('app', '生命恢复'),
            'mp_recover' => Yii::t('app', '魔法恢复'),
            'poison_recover' => Yii::t('app', '中毒恢复'),
            'price' => Yii::t('app', '价格'),
            'mabi_prob' => Yii::t('app', '麻痹几率(万分比)'),
            'mabi_dura' => Yii::t('app', '麻痹时长(毫秒)'),
            'anti_mabi' => Yii::t('app', '麻痹闪避'),
            'frozen_prob' => Yii::t('app', '冰冻几率(万分比)'),
            'frozen_dura' => Yii::t('app', '冰冻时长(毫秒)'),
            'relive_prob' => Yii::t('app', '复活几率'),
            'relive_pres' => Yii::t('app', '复活血量加成'),
            'relive_cd' => Yii::t('app', ' 复活冷却CD'),
            'anti_relive' => Yii::t('app', '破复活几率'),
            'pveqiege_prob' => Yii::t('app', 'PVE切割几率'),
            'pveqiege_pres' => Yii::t('app', 'PVE切割加成'),
            'pvpqiege_prob' => Yii::t('app', 'PVP切割几率'),
            'pvpqiege_pres' => Yii::t('app', 'PVP切割加成'),
            'xixue_prob' => Yii::t('app', '吸血几率'),
            'xixue_pres' => Yii::t('app', '吸血加成'),
            'baoji_prob' => Yii::t('app', '暴击几率'),
            'baojipvp_pres' => Yii::t('app', 'PVP暴击几率'),
            'baojipve_pres' => Yii::t('app', 'PVE暴击几率'),
            'baoji_point' => Yii::t('app', '暴击伤害'),
            'baojipvp_point' => Yii::t('app', 'PVP暴击伤害'),
            'baojipve_point' => Yii::t('app', 'PVE暴击伤害'),
            'anti_baoji' => Yii::t('app', '防爆击率'),
            'shouhu_pres' => Yii::t('app', '守护加成'),
            'attack_pres' => Yii::t('app', '攻击加成'),
            'defense_pres' => Yii::t('app', '防御加成'),
            'addharm_pres' => Yii::t('app', '伤害加成'),
            'pvpharm_pres' => Yii::t('app', 'PVP伤害加成'),
            'pveharm_pres' => Yii::t('app', 'PVE伤害加成'),
            'subharm_pres' => Yii::t('app', '减伤加成'),
            'atkspd_pres' => Yii::t('app', '攻速加成'),
            'hetitime_pres' => Yii::t('app', '合体时间加成'),
            'heticd_pres' => Yii::t('app', '合体减CD加成'),
            'real_harm' => Yii::t('app', '真实伤害'),
            'drop_pres' => Yii::t('app', '杀怪爆率加成'),
            'equip_comp' => Yii::t('app', '装备对比'),
            'contribute' => Yii::t('app', '装备贡献'),
            'huishou_exp' => Yii::t('app', '回收积分'),
            'huishou_jinbi' => Yii::t('app', '回收金币'),
            'huishou_vcoin' => Yii::t('app', '回收元宝'),
            'description' => Yii::t('app', '物品描述'),
        ];
    }
}
