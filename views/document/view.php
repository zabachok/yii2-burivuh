<?php

use yii\widgets\Breadcrumbs;
use zabachok\burivuh\assets\BurivuhAsset;

$this->title = $model->title;

BurivuhAsset::register($this);
$this->registerJs('burivuh.view.init();');

echo Breadcrumbs::widget([
    'links' => $model->breadcrumbs,
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => ['/burivuh/category/index']],
]);
?>

<?= $this->render('_panel', ['model' => $model]) ?>
<div class="row">
    <div class="col-md-12">
        <h2><?= Yii::t('burivuh', 'Hot keys') ?></h2>
        <span class="label label-default">Ctrl</span> + <span class="label label-default">e</span>
        - <?= Yii::t('burivuh', 'edit the document') ?><br>
    </div>
</div>