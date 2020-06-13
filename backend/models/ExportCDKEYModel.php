<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-05-28
 * Time: 16:01
 */

namespace backend\models;


use yii\db\Exception;

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
        $query=self::find()
            ->select(['total'=>'count(varietyId)','varietyId'])
            ->groupBy(['varietyId'])
            ->asArray();
        $data=$query->all();
        for ($i=0;$i<count($data);$i++)
        {
            $lastId=$this->getLastExportId(self::$gameId,self::$distributorId,$data[$i]['varietyId']);
            $surplusQuery=self::find()->where(['varietyId'=>$data[$i]['varietyId']])->andWhere(['>','id',$lastId]);
            $surplus=$surplusQuery->count();
            $data[$i]['gameId']=self::$gameId;
            $data[$i]['distributorId']=self::$distributorId;
            $data[$i]['surplus']=$surplus;
        }
        return $data;
    }

    /**x
     * 获取最后导出激活码ID
     * @param $gameId 游戏ID
     * @param $varietyId 激活码类型
     * @return int|mixed
     */
    public function getLastExportId($gameId,$distributorId,$varietyId)
    {
        $lastQuery=TabCdkeyExport::find()->where(['varietyId'=>$varietyId,'gameId'=>$gameId,'distributorId'=>$distributorId])->orderBy('id DESC');
        $last=$lastQuery->limit(1)->one();
        if (!empty($last))
        {
            return $last->lastId;
        }
        return 0;
    }
    /**
     * 根据激活码类型导出激活码
     * @param $varietyId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCdkeys($varietyId,$lastId,$num)
    {
        $query=self::find()->select(['id','cdkey'])
            ->where(['varietyId'=>$varietyId])
            ->andWhere(['>','id',$lastId])
            ->limit($num)->asArray();
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

    /**
     * 激活码Excel下载
     * @param $gameId 游戏ID
     * @param $distributorId 分销商ID
     * @param $varietyId 激活码类型ID
     * @param $num 导出数量
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function downloadExcel($gameId,$distributorId,$varietyId,$num)
    {
        ini_set('max_execution_time',0); //设置程序的执行时间,0为无上限

        $variety=TabCdkeyVariety::find()->where(['id'=>$varietyId,'gameId'=>$gameId])->one();

        $lastId=$this->getLastExportId($gameId,$distributorId,$varietyId);

        $data=$this->getCdkeys($varietyId,$lastId,$num);

        if (empty($data))
        {
            return json_encode(['code'=>-1,'msg'=>'未找到激活信息']);
        }
        $lastId=$data[count($data)-1]['id'];
        $title="激活码";
        if (true)
        {
            $objPHPExcel = new \PHPExcel();
            $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
            $objPHPExcel->getActiveSheet()->setCellValue('A1',  $title."类型:".$variety->name." 共[$num]个");
            $step=0;
            //遍历数据
            foreach ($data as $key => $value) {
                if($step==1000){ //每次写入1000条数据清除内存
                    $step=0;
                    ob_flush();//清除内存
                    flush();
                }
                $i=$key+2;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,  $value['cdkey']);
            }
            //下载这个表格，在浏览器输出
            $file_name = $title."_".$variety->getAttribute('name')."(".$num."个)";
            header("Pragma: public");
            header("Expires: 0");

            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");;
            header('Content-Disposition:attachment;filename='.$file_name.'.xls');
            header("Content-Transfer-Encoding:binary");
            $objWriter->save('php://output');
        }

        try{
            $this->saveExportLog($gameId,$distributorId,$varietyId,$num,$lastId);
        }catch (Exception $exception)
        {

        }
        die();
    }
    public function saveExportLog($gameId,$distributorId,$varietyId,$num,$lastId)
    {
        $exportLog=new TabCdkeyExport();
        $exportLog->varietyId=$varietyId;
        $exportLog->gameId=$gameId;
        $exportLog->num=$num;
        $exportLog->logTime=time();
        $exportLog->distributorId=$distributorId;
        $exportLog->lastId=$lastId;//
        $exportLog->userId=\Yii::$app->getUser()->id;

        if($exportLog->save())
        {
            return true;
        }else{
            exit(json_encode($exportLog->getErrors()));
        }
    }
}