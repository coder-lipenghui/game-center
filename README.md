# 奇游游戏中控后台
[![Build Status](https://dev.azure.com/xxdweb/Game-Center/_apis/build/status/coder-lipenghui.qiyou-center?branchName=master)](https://dev.azure.com/xxdweb/Game-Center/_build/latest?definitionId=1&branchName=master)

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
