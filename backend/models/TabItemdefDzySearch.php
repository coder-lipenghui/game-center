<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabItemdefDzy;

/**
 * TabItemdefDzySearch represents the model behind the search form of `backend\models\TabItemdefDzy`.
 */
class TabItemdefDzySearch extends TabItemdefDzy
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'wear_pos', 'sub_type', 'res_id', 'icon_id', 'weight', 'stackmax', 'job', 'gender', 'needlevel', 'needzslv', 'equip_lv', 'fightpoint', 'last_time', 'gift_id', 'duramax', 'flags', 'pinzhi', 'protect', 'drop_luck', 'ac', 'ac2', 'mac', 'mac2', 'dc', 'dc2', 'mc', 'mc2', 'sc', 'sc2', 'max_hp', 'max_mp', 'max_hp_pres', 'max_mp_pres', 'luck', 'curse', 'accuracy', 'dodge', 'anti_magic', 'anti_poison', 'hp_recover', 'mp_recover', 'poison_recover', 'price', 'mabi_prob', 'mabi_dura', 'anti_mabi', 'frozen_prob', 'frozen_dura', 'relive_prob', 'relive_pres', 'relive_cd', 'anti_relive', 'pveqiege_prob', 'pveqiege_pres', 'pvpqiege_prob', 'pvpqiege_pres', 'xixue_prob', 'xixue_pres', 'baoji_prob', 'baojipvp_pres', 'baojipve_pres', 'baoji_point', 'baojipvp_point', 'baojipve_point', 'anti_baoji', 'shouhu_pres', 'attack_pres', 'defense_pres', 'addharm_pres', 'pvpharm_pres', 'pveharm_pres', 'subharm_pres', 'atkspd_pres', 'hetitime_pres', 'heticd_pres', 'real_harm', 'drop_pres', 'equip_comp', 'contribute', 'huishou_exp', 'huishou_jinbi', 'huishou_vcoin'], 'integer'],
            [['script', 'name', 'color', 'description'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TabItemdefDzy::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'wear_pos' => $this->wear_pos,
            'sub_type' => $this->sub_type,
            'res_id' => $this->res_id,
            'icon_id' => $this->icon_id,
            'weight' => $this->weight,
            'stackmax' => $this->stackmax,
            'job' => $this->job,
            'gender' => $this->gender,
            'needlevel' => $this->needlevel,
            'needzslv' => $this->needzslv,
            'equip_lv' => $this->equip_lv,
            'fightpoint' => $this->fightpoint,
            'last_time' => $this->last_time,
            'gift_id' => $this->gift_id,
            'duramax' => $this->duramax,
            'flags' => $this->flags,
            'pinzhi' => $this->pinzhi,
            'protect' => $this->protect,
            'drop_luck' => $this->drop_luck,
            'ac' => $this->ac,
            'ac2' => $this->ac2,
            'mac' => $this->mac,
            'mac2' => $this->mac2,
            'dc' => $this->dc,
            'dc2' => $this->dc2,
            'mc' => $this->mc,
            'mc2' => $this->mc2,
            'sc' => $this->sc,
            'sc2' => $this->sc2,
            'max_hp' => $this->max_hp,
            'max_mp' => $this->max_mp,
            'max_hp_pres' => $this->max_hp_pres,
            'max_mp_pres' => $this->max_mp_pres,
            'luck' => $this->luck,
            'curse' => $this->curse,
            'accuracy' => $this->accuracy,
            'dodge' => $this->dodge,
            'anti_magic' => $this->anti_magic,
            'anti_poison' => $this->anti_poison,
            'hp_recover' => $this->hp_recover,
            'mp_recover' => $this->mp_recover,
            'poison_recover' => $this->poison_recover,
            'price' => $this->price,
            'mabi_prob' => $this->mabi_prob,
            'mabi_dura' => $this->mabi_dura,
            'anti_mabi' => $this->anti_mabi,
            'frozen_prob' => $this->frozen_prob,
            'frozen_dura' => $this->frozen_dura,
            'relive_prob' => $this->relive_prob,
            'relive_pres' => $this->relive_pres,
            'relive_cd' => $this->relive_cd,
            'anti_relive' => $this->anti_relive,
            'pveqiege_prob' => $this->pveqiege_prob,
            'pveqiege_pres' => $this->pveqiege_pres,
            'pvpqiege_prob' => $this->pvpqiege_prob,
            'pvpqiege_pres' => $this->pvpqiege_pres,
            'xixue_prob' => $this->xixue_prob,
            'xixue_pres' => $this->xixue_pres,
            'baoji_prob' => $this->baoji_prob,
            'baojipvp_pres' => $this->baojipvp_pres,
            'baojipve_pres' => $this->baojipve_pres,
            'baoji_point' => $this->baoji_point,
            'baojipvp_point' => $this->baojipvp_point,
            'baojipve_point' => $this->baojipve_point,
            'anti_baoji' => $this->anti_baoji,
            'shouhu_pres' => $this->shouhu_pres,
            'attack_pres' => $this->attack_pres,
            'defense_pres' => $this->defense_pres,
            'addharm_pres' => $this->addharm_pres,
            'pvpharm_pres' => $this->pvpharm_pres,
            'pveharm_pres' => $this->pveharm_pres,
            'subharm_pres' => $this->subharm_pres,
            'atkspd_pres' => $this->atkspd_pres,
            'hetitime_pres' => $this->hetitime_pres,
            'heticd_pres' => $this->heticd_pres,
            'real_harm' => $this->real_harm,
            'drop_pres' => $this->drop_pres,
            'equip_comp' => $this->equip_comp,
            'contribute' => $this->contribute,
            'huishou_exp' => $this->huishou_exp,
            'huishou_jinbi' => $this->huishou_jinbi,
            'huishou_vcoin' => $this->huishou_vcoin,
        ]);

        $query->andFilterWhere(['like', 'script', $this->script])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
