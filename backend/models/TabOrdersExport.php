<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TabOrders;
use yii\helpers\ArrayHelper;

/**
 * TabOrdersExport represents the model behind the search form of `backend\models\TabOrders`.
 */
class TabOrdersExport extends TabOrders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payTime'],'required'],
            [['distributorId'],'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    /**
     * 根据渠道id、时间导出订单数据
     * @param $params 包含渠道id、时间
     */
    public function getOrderData($distributorId,$payTime)
    {
        $query = TabOrders::find();
        $query
            ->andFilterWhere(['distributorId'=>$distributorId])
            ->andFilterWhere(['payStatus'=>'1'])
            ->andFilterWhere(["FROM_UNIXTIME(payTime,'%Y-%m')"=>$payTime])
            ->select(['gameId','orderId','distributionOrderId','payAmount','payTime'=>'FROM_UNIXTIME(payTime,\'%Y-%m-%d %H:%i:%s\')'])->asArray()
            ->orderBy('gameId');
        return $query->all();
    }
    public function download()
    {
        $request=\Yii::$app->request;
        $this->load($request->post());

        if ($this->validate())
        {
            if (empty($this->distributorId))
            {
                $distributors=TabDistributor::find()->select(['id','name'])->asArray()->all();
                $distributor=ArrayHelper::map($distributors,'id','name');
                foreach ($distributor as $k=>$v)
                {
                    $data=$this->getOrderData($k,$this->payTime);
                    if (!empty($data))
                    {
                        $this->generateExcel($data,$v,$this->payTime);
                    }
                }
            }else
            {
                $distributor=TabDistributor::find()->where(['id'=>$this->distributorId])->one();
                $distributorName=$distributor->name;
                $data=$this->getOrderData($this->distributorId,$this->payTime);
                $this->generateExcel($data,$distributorName,$this->payTime);
            }
        }
        return null;
    }
    private function generateExcel($data,$distributorName,$time)
    {

        $games=TabGames::find()->select(['id','name'])->asArray()->all();
        $games=ArrayHelper::map($games,'id','name');
        $title="[".$distributorName."][".$time."]充值订单详情";
        $objPHPExcel = new \PHPExcel();
        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
        $objPHPExcel->getActiveSheet()->setCellValue('A1',  $title);

        $objPHPExcel->getActiveSheet()->setCellValue('A2',  '游戏名称');
        $objPHPExcel->getActiveSheet()->setCellValue('B2',  '研发订单');
        $objPHPExcel->getActiveSheet()->setCellValue('C2',  '渠道订单');
        $objPHPExcel->getActiveSheet()->setCellValue('D2',  '金额(单位:分)');
        $objPHPExcel->getActiveSheet()->setCellValue('E2',  '支付时间');
        $step=0;
        //遍历数据
        foreach ($data as $key => $value) {
            if($step==1000){ //每次写入1000条数据清除内存
                $step=0;
                ob_flush();//清除内存
                flush();
            }
            $i=$key+3;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,  $games[$value['gameId']]);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,  $value['orderId']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,  ($value['distributionOrderId']." "));
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,  ($value['payAmount']));
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,  $value['payTime']);
        }
        //下载这个表格，在浏览器输出
        $file_name = $title;
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
        die();
    }
}
