# 奇游游戏中控后台
项目分两部分
* 中控管理
    * 用户群组及权限管理
    * 游戏开区、公告、更新等相关操作
    * 游戏数据分析：玩家生态环境、活动参与度等
    * 数据分析：活跃、留存等
* API功能
    * 玩家日志查询
## 注意事项
1. model业务逻辑操作需要从Gii生成的model中剥离（新增model继承自生成的model）
## 分销商SDK登录充值接口编写
1. 在后台中添加游戏、分销商、分销渠道(android/ios)，填写分销渠道对应的参数
1. 新增分销商名称拼音controller,继承``center\CenterController.php``
1. 重写``loginValidate()``方法用于分销商侧登录验证
1. 重写``orderValidate()``方法用于分销商侧订单验证
1. 定义返分销商需要的返回值信息，目前暂定了4种：
    * 发货失败：         ``paymentDeliverFailed``
    * 订单支付金额不匹配：``paymentAmountFailed``
    * 重复订单：         ``paymentRepeatingOrder``
    * 订单验证失败：      ``paymentValidateFailed``
    * 支付成功：         ``paymentSuccess``
    
    各渠道要求的返回信息不同，大多以json、字符串为主，返回信息需要在各controller中重新定义
## 用到的第三方库
* **AdminLTE** web样式
* **kartik-v/yii2-widget-select2** 下拉框
* **kartik-v/yii2-widget-datetimepicker** 日期选取
* **PhpExcel** excel导出
## 目录概要：
```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    ß
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
        api/             游戏API接口部分
        center/          中控管理部分
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
vendor/                  contains dependent 3rd-party packages
```
