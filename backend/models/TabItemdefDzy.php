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
            'id' => Yii::t('app', 'ID'),
            'wear_pos' => Yii::t('app', 'Wear Pos'),
            'sub_type' => Yii::t('app', 'Sub Type'),
            'res_id' => Yii::t('app', 'Res ID'),
            'icon_id' => Yii::t('app', 'Icon ID'),
            'script' => Yii::t('app', 'Script'),
            'name' => Yii::t('app', 'Name'),
            'color' => Yii::t('app', 'Color'),
            'weight' => Yii::t('app', 'Weight'),
            'stackmax' => Yii::t('app', 'Stackmax'),
            'job' => Yii::t('app', 'Job'),
            'gender' => Yii::t('app', 'Gender'),
            'needlevel' => Yii::t('app', 'Needlevel'),
            'needzslv' => Yii::t('app', 'Needzslv'),
            'equip_lv' => Yii::t('app', 'Equip Lv'),
            'fightpoint' => Yii::t('app', 'Fightpoint'),
            'last_time' => Yii::t('app', 'Last Time'),
            'gift_id' => Yii::t('app', 'Gift ID'),
            'duramax' => Yii::t('app', 'Duramax'),
            'flags' => Yii::t('app', 'Flags'),
            'pinzhi' => Yii::t('app', 'Pinzhi'),
            'protect' => Yii::t('app', 'Protect'),
            'drop_luck' => Yii::t('app', 'Drop Luck'),
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
            'max_hp' => Yii::t('app', 'Max Hp'),
            'max_mp' => Yii::t('app', 'Max Mp'),
            'max_hp_pres' => Yii::t('app', 'Max Hp Pres'),
            'max_mp_pres' => Yii::t('app', 'Max Mp Pres'),
            'luck' => Yii::t('app', 'Luck'),
            'curse' => Yii::t('app', 'Curse'),
            'accuracy' => Yii::t('app', 'Accuracy'),
            'dodge' => Yii::t('app', 'Dodge'),
            'anti_magic' => Yii::t('app', 'Anti Magic'),
            'anti_poison' => Yii::t('app', 'Anti Poison'),
            'hp_recover' => Yii::t('app', 'Hp Recover'),
            'mp_recover' => Yii::t('app', 'Mp Recover'),
            'poison_recover' => Yii::t('app', 'Poison Recover'),
            'price' => Yii::t('app', 'Price'),
            'mabi_prob' => Yii::t('app', 'Mabi Prob'),
            'mabi_dura' => Yii::t('app', 'Mabi Dura'),
            'anti_mabi' => Yii::t('app', 'Anti Mabi'),
            'frozen_prob' => Yii::t('app', 'Frozen Prob'),
            'frozen_dura' => Yii::t('app', 'Frozen Dura'),
            'relive_prob' => Yii::t('app', 'Relive Prob'),
            'relive_pres' => Yii::t('app', 'Relive Pres'),
            'relive_cd' => Yii::t('app', 'Relive Cd'),
            'anti_relive' => Yii::t('app', 'Anti Relive'),
            'pveqiege_prob' => Yii::t('app', 'Pveqiege Prob'),
            'pveqiege_pres' => Yii::t('app', 'Pveqiege Pres'),
            'pvpqiege_prob' => Yii::t('app', 'Pvpqiege Prob'),
            'pvpqiege_pres' => Yii::t('app', 'Pvpqiege Pres'),
            'xixue_prob' => Yii::t('app', 'Xixue Prob'),
            'xixue_pres' => Yii::t('app', 'Xixue Pres'),
            'baoji_prob' => Yii::t('app', 'Baoji Prob'),
            'baojipvp_pres' => Yii::t('app', 'Baojipvp Pres'),
            'baojipve_pres' => Yii::t('app', 'Baojipve Pres'),
            'baoji_point' => Yii::t('app', 'Baoji Point'),
            'baojipvp_point' => Yii::t('app', 'Baojipvp Point'),
            'baojipve_point' => Yii::t('app', 'Baojipve Point'),
            'anti_baoji' => Yii::t('app', 'Anti Baoji'),
            'shouhu_pres' => Yii::t('app', 'Shouhu Pres'),
            'attack_pres' => Yii::t('app', 'Attack Pres'),
            'defense_pres' => Yii::t('app', 'Defense Pres'),
            'addharm_pres' => Yii::t('app', 'Addharm Pres'),
            'pvpharm_pres' => Yii::t('app', 'Pvpharm Pres'),
            'pveharm_pres' => Yii::t('app', 'Pveharm Pres'),
            'subharm_pres' => Yii::t('app', 'Subharm Pres'),
            'atkspd_pres' => Yii::t('app', 'Atkspd Pres'),
            'hetitime_pres' => Yii::t('app', 'Hetitime Pres'),
            'heticd_pres' => Yii::t('app', 'Heticd Pres'),
            'real_harm' => Yii::t('app', 'Real Harm'),
            'drop_pres' => Yii::t('app', 'Drop Pres'),
            'equip_comp' => Yii::t('app', 'Equip Comp'),
            'contribute' => Yii::t('app', 'Contribute'),
            'huishou_exp' => Yii::t('app', 'Huishou Exp'),
            'huishou_jinbi' => Yii::t('app', 'Huishou Jinbi'),
            'huishou_vcoin' => Yii::t('app', 'Huishou Vcoin'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
