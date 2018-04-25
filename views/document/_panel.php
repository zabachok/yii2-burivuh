<?php

use yii\helpers\Html;

?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?=
        Html::a(
            '<i class="glyphicon glyphicon-pencil"></i> ', [
            '/burivuh/document/update',
            'title' => $model->title,
            'document_id' => $model->document_id,
        ], [
            'class' => 'btn btn-success btn-sm',
            'tabindex' => 1,
            'id' => 'burivuh-update-link',
            'title' => Yii::t('burivuh', 'Update')
        ])
        ?>
        <b><?= $model->title ?></b>
        <div class="pull-right">
            <?= $model->timeAgo ?>
            <?= Html::a(
                '<i class="glyphicon glyphicon-list"></i> ',
                ['/burivuh/history/index', 'title' => $model->title, 'document_id' => $model->document_id],
                ['class' => 'btn btn-default btn-sm', 'title' => Yii::t('burivuh', 'Сhange history')]
            ) ?>
            <?= Html::a(
                '<i class="glyphicon glyphicon-trash"></i> ',
                ['/burivuh/document/delete', 'title' => $model->title, 'document_id' => $model->document_id],
                ['class' => 'btn btn-warning btn-sm', 'title' => Yii::t('burivuh', 'Delete')]
            ) ?>
        </div>
    </div>
    <div class="panel-body"><?= $model->content ?></div>
</div>