<?php
use kartik\datetime\DateTimePicker;
$this->title="";
$this->registerJsFile("@web/js/echarts.min.js",['position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile("@web/js/common.js",['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile("@web/js/analyze/server.js",['position'=>\yii\web\View::POS_HEAD]);

use yii\helpers\Html; ?>

<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-1">
                <?= Html::dropDownList("游戏",
                    [],
                    $games,
                    [
                        'class'=>'selectpicker form-control col-md-2',
                        'title'=>'游戏',
                        'id'=>'retainGames',
                        'onchange'=>'changeGame()'
                    ])?>
            </div>
            <div class="col-md-2">
                <?= Html::dropDownList("渠道",
                    [],
                    $games,
                    [
                        'class'=>'selectpicker form-control col-md-2',
                        'title'=>'渠道',
                        'id'=>'retainDistributors',
                        'onchange'=>'changeDistributor()'
                    ])?>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
<div class="panel panel-default">
    <!-- 查询 -->
    <div class="panel-heading">
        <label class="text text-default">最新</label>&nbsp;<input value="10" size="5" id="latestServers"/>&nbsp;<label>个区</label>
        <button class="btn btn-primary btn-small" onclick="searchLatestServers()">查询</button>
    </div>

    <!--  结果集  -->
    <div class="panel-body">
        <table class="table table-condensed table-bordered table-striped hidden" id="tableTop">
            <thead style="background: #41464b;color: #f3f3f4;">
                <td>区服</td>
                <td>新进</td>
                <td>次留</td>
                <td>3留</td>
                <td>5留</td>
                <td>7留</td>
                <td>15留</td>
                <td>30留</td>
            </thead>
            <tbody id="top10">

            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-2">
                        <label>单服查看</label>
                        <?= Html::dropDownList("区服",
                            [],
                            [],
                            [
                                'class'=>'selectpicker form-control fit',
                                'title'=>'区服',
                                'id'=>'retainServers1',
                                "data-width"=>"fit"
                            ])?>
                    </div>
                    <div class="col-md-2">
                        <?=
                        DateTimePicker::widget([
                            'model'=>DateTimePicker::className(),
                            'name'=>'startDate',
                            'id'=>'date1',
                            'options' => [
                                'placeholder' => '日期',
                                'display'=>'inline'
                            ],
                            'pluginOptions' => [
                                'format'=>'yyyy-mm-dd',
                                'autoclose' => true,
                                'startView'=>2,
                                'maxView'=>3,  //最大选择范围（年）
                                'minView'=>2,  //最小选择范围（年）
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-primary" onclick="searchSingleDate()">查询</button>
                    </div>
                </div>
                    <table class="table table-condensed table-bordered table-striped hidden" id="tableSingleDate">
                        <thead style="background: #41464b;color: #f3f3f4;">

                        <td>新进</td>
                        <td>次留</td>
                        <td>3留</td>
                        <td>5留</td>
                        <td>7留</td>
                        <td>15留</td>
                        <td>30留</td>
                        </thead>
                        <tbody id="tbSingleDate">

                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <label>持续跟踪</label>
                    <?= Html::dropDownList("区服",
                        [],
                        [],
                        [
                            'class'=>'selectpicker form-control fit',
                            'title'=>'区服',
                            'id'=>'retainServers2',
                            "data-width"=>"fit"
                        ])?>
                </div>

                <div class="col-md-2">
                    <?=
                    DateTimePicker::widget([
                        'model'=>DateTimePicker::className(),
                        'name'=>'startDate',
                        'id'=>'date2',
                        'options' => [
                            'placeholder' => '开区时间',
                            'display'=>'inline'
                        ],
                        'pluginOptions' => [
                            'format'=>'yyyy-mm-dd',
                            'autoclose' => true,
                            'startView'=>2,
                            'maxView'=>3,  //最大选择范围（年）
                            'minView'=>2,  //最小选择范围（年）
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-md-3">
                    <label>持续</label>
                    <input value="10" size="5" id="singleDays"/>&nbsp;天
                    <button class="btn btn-primary" onclick="searchSingleDays()">查询</button>
                </div>
            </div>
                <table class="table table-condensed table-bordered table-striped hidden" id="tableSingleDays">
                    <thead style="background: #41464b;color: #f3f3f4;">
                    <td>日期</td>
                    <td>新进</td>
                    <td>次留</td>
                    <td>3留</td>
                    <td>5留</td>
                    <td>7留</td>
                    <td>15留</td>
                    <td>30留</td>
                    </thead>
                    <tbody id="tbSingleDays">

                    </tbody>
                </table>
        </div>
    </div>
</div>
</div>
    </div>

