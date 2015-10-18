<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use zabachok\burivuh\assets\BurivuhAsset;

BurivuhAsset::register($this);
$this->registerJs('burivuh.view.init();');

echo Breadcrumbs::widget([
    'links'    => isset($breadcrumbs) ? $breadcrumbs : [],
    'homeLink' => false,
]);
?>

<?=$this->render('_panel', ['model'=>$model])?>
<div class="row">
    <div class="col-md-12">
        <h2><?= Yii::t('burivuh', 'Hot keys')?></h2>
        <span class="label label-default">Ctrl</span> + <span class="label label-default">e</span> - <?= Yii::t('burivuh', 'edit the document')?><br>
    </div>
</div>