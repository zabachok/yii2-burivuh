<?php

use yii\helpers\Html;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?=
        Html::a(
            '<i class="glyphicon glyphicon-pencil"></i> ', [
            '/burivuh/main/update',
            'path' => $model->path
            ], [
            'class'    => 'btn btn-success btn-sm',
            'tabindex' => 1,
            'id'       => 'burivuh-update-link',
            'title'    => Yii::t('burivuh', 'Update')
        ])
        ?>
        <b><?= $model->name?></b>
        <div class="pull-right">
            <?= $model->timeAgo?>
            <?= Html::a('<i class="glyphicon glyphicon-trash"></i> ', ['/burivuh/main/delete', 'path' => $model->path], ['class' => 'btn btn-warning btn-sm', 'title' => Yii::t('burivuh', 'Delete')])?>
        </div>
    </div>
    <div class="panel-body"><?= $model->markdown?></div>
</div>