<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-28
 * Time: 16:01
 */

namespace backend\models;


class ExportCDKEYModel extends AutoCDKEYModel
{
    public function rules()
    {
        return [
            [['gameId','distributorId'],'required'],
            [['gameId','distributorId'],'integer'],
        ];
    }

    /**
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function groupByVariety()
    {
//        self::TabSuffix($gameId,$distributorId);
        $query=self::find()
            ->select(['total'=>'count(varietyId)','varietyId'])
            ->groupBy(['varietyId'])
            ->asArray();
        $data=$query->all();
        for ($i=0;$i<count($data);$i++)
        {
            $data[$i]['gameId']=self::$gameId;
            $data[$i]['distributorId']=self::$distributorId;
        }
        return $data;
    }

    /**
     * 根据激活码类型导出激活码
     * @param $varietyId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCdkeys($varietyId)
    {
        $query=self::find()->select(['cdkey'])->where(['varietyId'=>$varietyId])->asArray();//->limit(1)

        $data=$query->all();

        return $data;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariety()
    {
        return $this->hasOne(TabCdkeyVariety::className(), ['id' => 'varietyId']);
    }
}