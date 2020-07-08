<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TabDistribution */

$this->title = '渠道参数';//$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', '渠道列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJs("
    $('#btnCopy').click(function () {
       var content=$('#packageParam').text();
        var aux=document.createElement('textarea');
//        aux.setAttribute('value',content);
        aux.value=content;
        document.body.appendChild(aux);
        aux.select();
        document.execCommand('copy');
        document.body.removeChild(aux);
        alert('复制成功');
    });
");
?>

<div class="tab-distribution-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel">
        <div class="panel panel-heading">
            安卓打包参数&nbsp;<span class="glyphicon glyphicon-duplicate" id="btnCopy"></span>
        </div>
        <div class="panel panel-body" id="packageParam"><?php echo ("<label class='text-lowercase'>".$model->game->sku."</label> {<br/>
applicationId \"$model->packageName\"<br/>
versionName \"$model->versionName\"<br/>
versionCode $model->versionCode<br/>
buildConfigField \"String\",\"distribution_appId\",\"\\\"$model->appID\\\"\"<br/>
buildConfigField \"String\",\"distribution_appKey\",\"\\\"$model->appKey\\\"\"<br/>
buildConfigField \"String\",\"game_sku\",\"\\\"".$model->game->sku."\\\"\"<br/>
buildConfigField \"int\",\"game_distribution\",\"$model->id\"<br/>
buildConfigField \"String\",\"game_channel\",\"\\\"<label class='text-lowercase'>$model->api</label>\\\"\"<br/>
buildConfigField \"String\",\"bugly_id\",\"\\\"cb437e2282\\\"\"<br/>
manifestPlaceholders=[<br/>
\"game_name\":\"".$model->game->name."\",<br/>
\"game_icon\":\"@mipmap/icon_<label class='text-lowercase'>".$model->game->sku."</label>\"<br/>
]<br/>
}<br/>");
?>
</div>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'gameId',
            'platform',
            'distributorId',
            'parentDT',
            'mingleDistributionId',
            'mingleServerId',
            'centerLoginKey',
            'centerPaymentKey',
            'packageName',
            'versionCode',
            'versionName',
            'appID',
            'appKey',
            'appLoginKey',
            'appPaymentKey',
            'appPublicKey',
            'enabled',
            'isDebug',
            'api',

        ],
    ]) ?>
</div>
