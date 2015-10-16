<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;


echo Breadcrumbs::widget([
    'links'    => isset($breadcrumbs) ? $breadcrumbs : [],
    'homeLink' => false,
]);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> ', ['/burivuh/main/update', 'path' => $model->path], ['class' => 'btn btn-success btn-sm', 'tabindex'=>1])?>
        <b><?= $model->name?></b>
        <div class="pull-right">
            <?= Html::a('<i class="glyphicon glyphicon-trash"></i> ', ['/burivuh/main/delete', 'path' => $model->path], ['class' => 'btn btn-warning btn-sm'])?>
        </div>
    </div>
    <div class="panel-body"><?= $model->markdown?></div>
</div>