<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model backend\models\TabServersKuafu */

$this->title = "设置跨服";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tab Servers Kuafus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJsFile('@web/js/common.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/kuafu.js',['depends'=>'yii\web\YiiAsset']);
?>
<?php Pjax::begin(); ?>
<div class="tab-servers-kuafu-view">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $form = ActiveForm::begin([
                'action' => ['edit'],
                'method' => 'get',
                'options' => [
                    'data-pjax' => 1
                ],
            ]); ?>
            <div class="row">
                <div class="col-md-2">
                    <?= $form->field($model, 'versionId')->dropDownList(array_merge([0=>'选择版本'],$versions),['id'=>'versions',"onchange"=>"getGames()"])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'gameId')->dropDownList([],['id'=>'kuafuGames'])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'url')->textInput(['maxlength' => true])->label(false) ?>
                </div>
                <div class="col-md-2">
                    <?= Html::submitButton(Yii::t('app', '查询'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default panel-primary">
                <div class="panel-heading">
                    已分配跨服的区服
                </div>
                <div class="panel-body">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <?php
//                        exit(json_encode($kfServers));
//                        for($i=0;$i<count($kfServers);$i++)
                        $i=0;
                        foreach ($kfServers as $k=>$v)
                        {
                            $name=$kfServers[$k][0]['kName'];
                            $url=$kfServers[$k][0]['kUrl'];
//                            exit("kkk:".$k);
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading<?=$i?>">
                                    <h4 class="panel-title">

                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$i?>" aria-expanded="true" aria-controls="collapse<?=$i?>">
                                            <?=$name;?>
                                        </a>
                                        <small><?=$url?></small>
                                    </h4>
                                </div>
                                <div id="collapse<?=$i?>" class="panel-collapse collapse <?php echo($i==0?"in":"");?>" role="tabpanel" aria-labelledby="heading<?=$i?>">
                                    <input type="hidden" value="<?=$k?>" id="kfServerId"/>
                                    <div class="panel-body">
                                        <?php
                                            foreach ($v as $kk=>$vv)
                                            {
                                                if ($vv['sName'])
                                                {
                                                    echo( "<div class='col-md-3'>".
                                                        "<div class='input-group'>".
                                                        "<span class='input-group-addon'>".
                                                        "<input type='checkbox' class='assigned' aria-label='' value='".$vv['sId']."'>".
                                                        "</span>".
                                                        "<input type='text' class='form-control' aria-label='' value='".$vv['sName']."'>".
                                                        "</div>".
                                                        "</div>");
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    操作
                </div>
                <div class="panel-body">
                    <div class="btn btn-danger" onclick="remove()">移除-></div>
                    <div class="btn btn-primary" onclick="add()"><-添加</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default panel-danger">
                <div class="panel-heading">
                    未分配跨服的区服
                </div>
                <div class="panel-body" id="divUndistributed">
                    <?php
                    foreach ($servers as $k=>$v)
                    {
                        echo( "<div class='col-md-3'>".
                            "<div class='input-group'>".
                            "<span class='input-group-addon'>".
                            "<input type='checkbox' class='undistributed' aria-label='' value='".$v['id']."'>".
                            "</span>".
                            "<input type='text' class='form-control' aria-label='' value='".$v['name']."'>".
                            "</div>".
                            "</div>");
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
