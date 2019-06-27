<?php
?>
<div class="alert alert-warning" role="alert">
    <div class="text-warning">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        CDN的版本存放结构：
        <ul>
            <li>
                |-gameId
                <ul>
                    <li>|-default
                        <ul>
                            <li>|-res</li>
                            <li>|-src</li>
                        </ul>
                    </li>
                    <li>|-distributionId(渠道1)
                        <ul>
                            <li>|-res</li>
                            <li>|-src</li>
                        </ul>
                    </li>

                    <li>|-distributionId(渠道2)</li>
                </ul>
            </li>
        </ul>
        <label>*资源文件地址: http://cdn地址/gameId/default|distributionid/version.manifest</label>
        <label>*选取了分销渠道后即表示该渠道需要单独维护版本，在CDN服务器上需要单独建立一个目录 例:http://xxx/gameId/distributionId/</label>
        <label>*[新增/修改]更新信息后,会调用CDN服务器的API接口刷新gameId目录</label>
    </div>
</div>
