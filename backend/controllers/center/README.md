# 游戏登录、充值验证、数据上报部分

## 一、SDK登录验证
玩家登录接口 校验部分下发到分销商的API接口类中

* 编写流程：
1. 新增`分销商名称Controller.php`继承自CenterController
2. 重写`loginValidate`方法进行验证
3. 返回必数组要信息
    ```php
    $player = array(
       'distributionUserId'        => '如果分销商侧有返回uid，使用返回的',
       'distributionUserAccount'   => '如果分销商侧有返回账号，则使用',
       'distributionId'            => $distribution->id,
    );
    ```
## 二、SDK订单回调验证
充值回调接口 开启url美化/payment-callback/distributionId 具体校验分发到各平台的API接口类中

* 编写流程
1. 重写`orderValidate`方法，由于各个分销商的请求方式不同，需要在该方法内自行获取请求参数
    ```php
    //以Quick为例：
    $request=\Yii::$app->request;
    $ntData=$request->get('nt_data');
    $body = array(
        'nt_data' => $ntData,
        'sign'=>$request->get('sign'),
    );
    ```
2. 定义返回信息，各分销商需要的返回信息不同，常规需要定义在`orderValidate`方法中
    ```php
       //以Quick为例子
       //构建返回信息
        $this->paymentDeliverFailed     = "DELIVER FAILED";  //发货失败
        $this->paymentAmountFailed      = "AMOUNT FAILED";   //订单金额不匹配
        $this->paymentRepeatingOrder    = "REPEATING ORDER"; //重复订单
        $this->paymentValidateFailed    = "VALIDATE FAILED"; //订单验证失败
        $this->paymentSuccess           = "SUCCESS";         //分销商侧需求的成功信息
    ```
3. 如果需要从分销商侧获取订单号及其他参数，需要重写`getOrderFromDistribution`方法
    ```php
   //示例
    public function getOrderFromDistribution($request)
    {
       //必须是一维数组，不要出现'orderId'字段，该字段会覆盖掉生成的订单ID
        return [
            'distributionOrderId'=>'分销商侧订单号',
            'accessKey'=>'其他字段',
            'other'=>'其他字段',
        ];
    }
    ```
    成功后，返回给游戏的数据如下：
    ```json
       {
           "code": 1,
           "msg": "success",
           "data": {
               "orderId": "7b2db0bc1447a383",
               "distributionOrderId": "分销商侧订单号",
               "accessKey": "其他字段",
               "other": "other"
           }
       }
    ```
## 数据上报
* 玩家信息上报，采集到的数据用于数据分析：转化率，留存，付费，玩家分析。
    * APP启动上报
    * 选服数据上报
    * 服务器登录成功(尚未进入游戏场景)数据上报
    * 登录上报
    * 创角上报
    * 进入游戏场景上报
    * 玩家升级上报
* 参数说明

    |参数|是否为空|说明|类型|示例|
    | - | :-: | :-: |:-: | -: |
    | sku | 否 | 游戏SKU | string | MYSC |
    | distid | 否 | 分销编号 | int | 1 |
    | uid | 否 | 用户ID | string | abc |
    | token | 否 | token | string | abc | 
	
