<?php
/**
 * Created by PhpStorm.
 * User: lipenghui
 * Date: 2019-04-19
 * Time: 22:00
 */

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use backend\models\TabActionType;
use yii\helpers\ArrayHelper;
use backend\models\TabSystem;

$this->title = Yii::t('app', '系统分布');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("@web/js/echarts.min.js",['position'=>\yii\web\View::POS_HEAD]);
$this->registerJsFile('@web/js/api/itemSearch.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/common.js');
$this->registerJsFile('@web/js/api/dropdown_menu.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/api/fun.js',['depends'=>'yii\web\YiiAsset']);
$this->registerJs("
$(function () {
  $('[data-toggle=\"tooltip\"]').tooltip()
})
");
?>
<div class="panel panel-default">
    <?php
    echo $this->render('_search', ['searchModel' => $searchModel,'games'=>$games,'distributors'=>$distributors,'servers'=>$servers]);
    ?>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <label>强化分布</label><label id="10011_Total"></label><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="强化统计规则:各强化等级占总人数百分比"></span>
    </div>
    <div class="panel-body" id="10011">

    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <label>镶嵌分布</label><label id="10012_Total">镶嵌分布</label><span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="bottom" title="镶嵌统计规则:每种类型宝石每个等级拥有数量"></span>
    </div>
    <div class="panel-body" id="10012">

    </div>
</div>
<?php
    $systems=TabSystem::find()->select(['systemId','type','systemName'])->where(['type'=>'pie'])->orderBy('systemId')->asArray()->all();
    $row=floor( count($systems)/3);
    $col=2;
//    exit($row." ".$col);
//    exit(json_encode($systems,JSON_UNESCAPED_UNICODE));
    for ($i=0;$i<$row;$i++)
    {
        echo("<div class='row'>");
        for ($j=0;$j<$col;$j++)
        {
            $id=$i*$col+$j;
            if ($systems[$id])
            {
                $system=$systems[$id];
                $name=$system['systemName'];
                $id=$system['systemId'];
                $pie="pie";
                echo("<div class=\"col-md-6\">
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                <label>$name</label><label id='".$id."_total'/>
                            </div>
                            <div class='panel-body' id=\"$id\">
                
                            </div>
                        </div>
                    </div>");
            }
        }
        echo("</div>");
    }
?>
</div>
