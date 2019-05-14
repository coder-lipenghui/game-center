# 游戏登录、充值验证、数据上报部分

## login
* 玩家登录接口 校验部分下发到渠道的API接口类中
## payment
* 充值回调接口 开启url美化/ordercallback/id 具体校验分发到各平台的API接口类中
## record 
* 玩家信息上报，采集到的数据用于数据分析：转化率、留存、职业分布等
    * 登录日志：包含设备信息
    * 创角日志：
    * 进入游戏：
    * 升级日志：
* 参数说明

    | 参数 | 是否为空 | 说明 | 类型 | 示例 |
    | --- | --- | --- | --- | --- | --- |
    | sku | 否 | 游戏SKU | string | MYSC |
    | distid | 否 | 渠道编号 | int | 1 |
    | uid | 否 | 用户ID | string | abc |
    | token | 否 | token | string | abc | 