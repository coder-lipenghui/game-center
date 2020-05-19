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
//showDistribution()
");
?>
<div class="panel panel-default">
    <?php
    echo $this->render('_search', ['searchModel' => $searchModel,'games'=>$games,'distributors'=>$distributors,'servers'=>$servers]);
    ?>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <label id="qianghuaTotal">强化分布</label>&nbsp;<button class="btn btn-primary" onclick="getDataByFunUrl('bar-stack',10011)">查看</button>
    </div>
    <div class="panel-body" id="10011">

    </div>
</div>
<?php
    $systems=TabSystem::find()->select(['systemId','systemName'])->where(['type'=>'pie'])->asArray()->all();
    $row=floor( count($systems)/3);
    $col=3;
//    exit($row." ".$col);
//    exit(json_encode($systems,JSON_UNESCAPED_UNICODE));
    for ($i=0;$i<$row;$i++)
    {
        echo("<div class='row'>");
        for ($j=0;$j<$col;$j++)
        {
            $id=$i*3+$j;
            if ($systems[$id])
            {
                $system=$systems[$id];
                $name=$system['systemName'];
                $id=$system['systemId'];
                $pie="pie";
                echo("<div class=\"col-md-4\">
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                <label id='".$id."_Total'>$name&nbsp;<div class='btn btn-primary' onclick=\"getDataByFunUrl('$pie',".$id.")\">查看</div></label>
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
