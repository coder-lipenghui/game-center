# 游戏中控后台
项目分三部分
* 登录充值相关
    * 平台侧SDK登录相关
    * 平台侧SDK充值：验证及发货
* 游戏相关管理
    * 用户群组及权限管理
    * 游戏开区、公告、更新等相关操作
    * 游戏数据分析：玩家生态环境、活动参与度等
    * 数据分析：活跃、留存等
* 游戏日志查询
    * 玩家日志查询:物品、货币、升级等日志信息
## 注意事项
1. model业务逻辑操作需要从Gii生成的model中剥离（新增model继承自生成的model）
## 分销商SDK登录充值接口编写
请前往controller/center目录查看README
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
