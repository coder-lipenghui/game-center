<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabItemdef;

/**
 * TabItemdefSearch represents the model behind the search form of `backend\models\TabItemdef`.
 */
class TabItemdefSearch extends TabItemdef
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sub_type', 'res_id', 'icon_id', 'weight', 'diejia', 'zhanli', 'last_time', 'giftid', 'duramax', 'notips', 'protect', 'ac', 'ac2', 'mac', 'mac2', 'dc', 'dc2', 'mc', 'mc2', 'sc', 'sc2', 'luck', 'unluck', 'hit', 'shanbi', 'shanbi_mf', 'shanbi_zd', 'HPhuifu', 'MPhuifu', 'fabaoparam', 'baojijilv', 'baojibaifenbi', 'baojijiacheng', 'needlevel', 'price', 'rand_range', 'rand_ac', 'rand_mac', 'rand_dc', 'rand_mc', 'rand_sc', 'add_base_ac', 'add_base_mac', 'add_base_dc', 'add_base_mc', 'add_base_sc', 'max_hp', 'max_mp', 'max_hp_pres', 'max_mp_pres', 'needZLv', 'needLv', 'needJob', 'needGender', 'compare', 'gongxian', 'destroyMsg', 'neigong', 'background', 'huishoujifen', 'huishoujinbi', 'huishouyuanbao'], 'integer'],
            [['script', 'name', 'shape', 'description'], 'safe'],
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
        $query = TabItemdef::find();

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
            'sub_type' => $this->sub_type,
            'res_id' => $this->res_id,
            'icon_id' => $this->icon_id,
            'weight' => $this->weight,
            'diejia' => $this->diejia,
            'zhanli' => $this->zhanli,
            'last_time' => $this->last_time,
            'giftid' => $this->giftid,
            'duramax' => $this->duramax,
            'notips' => $this->notips,
            'protect' => $this->protect,
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
            'luck' => $this->luck,
            'unluck' => $this->unluck,
            'hit' => $this->hit,
            'shanbi' => $this->shanbi,
            'shanbi_mf' => $this->shanbi_mf,
            'shanbi_zd' => $this->shanbi_zd,
            'HPhuifu' => $this->HPhuifu,
            'MPhuifu' => $this->MPhuifu,
            'fabaoparam' => $this->fabaoparam,
            'baojijilv' => $this->baojijilv,
            'baojibaifenbi' => $this->baojibaifenbi,
            'baojijiacheng' => $this->baojijiacheng,
            'needlevel' => $this->needlevel,
            'price' => $this->price,
            'rand_range' => $this->rand_range,
            'rand_ac' => $this->rand_ac,
            'rand_mac' => $this->rand_mac,
            'rand_dc' => $this->rand_dc,
            'rand_mc' => $this->rand_mc,
            'rand_sc' => $this->rand_sc,
            'add_base_ac' => $this->add_base_ac,
            'add_base_mac' => $this->add_base_mac,
            'add_base_dc' => $this->add_base_dc,
            'add_base_mc' => $this->add_base_mc,
            'add_base_sc' => $this->add_base_sc,
            'max_hp' => $this->max_hp,
            'max_mp' => $this->max_mp,
            'max_hp_pres' => $this->max_hp_pres,
            'max_mp_pres' => $this->max_mp_pres,
            'needZLv' => $this->needZLv,
            'needLv' => $this->needLv,
            'needJob' => $this->needJob,
            'needGender' => $this->needGender,
            'compare' => $this->compare,
            'gongxian' => $this->gongxian,
            'destroyMsg' => $this->destroyMsg,
            'neigong' => $this->neigong,
            'background' => $this->background,
            'huishoujifen' => $this->huishoujifen,
            'huishoujinbi' => $this->huishoujinbi,
            'huishouyuanbao' => $this->huishouyuanbao,
        ]);

        $query->andFilterWhere(['like', 'script', $this->script])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'shape', $this->shape])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
