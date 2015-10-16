<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$dirName = end(explode('/', $path));

echo Breadcrumbs::widget([
    'links'    => isset($breadcrumbs) ? $breadcrumbs : [],
    'homeLink' => false,
]);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= empty($dirName) ? 'Корневая диретория' : $dirName?>
        <div class="btn-group pull-right">
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i>&nbsp;Создать файл', ['/burivuh/main/create', 'path' => $path], ['class' => 'btn btn-success btn-xs'])?>
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i>&nbsp;Создать директорию', ['/burivuh/main/create-folder', 'path' => $path], ['class' => 'btn btn-success btn-xs'])?>
            <?= Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp;Удалить директорию', ['/burivuh/main/delete-folder', 'path' => $path], ['class' => 'btn btn-warning btn-xs'])?>
        </div>
    </div>

    <table class="table table-striped dtable-bordered table-hover panel-body">
        <?php
        if(empty($folder)) echo '<tr class="warning"><td class="text-center">Директория пуста</td></tr>';
        else
        {
            foreach($folder as $file)
            {
                ?>
                <tr class="<?= $file->isDir ? 'active' : ''?>">
                    <td>
                        <?= $file->isDir ? '<i class="glyphicon glyphicon-folder-close"></i>' : '<i class="glyphicon glyphicon-file"></i>'?>
                        <?=
                        Html::a($file->name, [
                            $file->isDir ? '/burivuh/main/index' : '/burivuh/main/view',
                            'path' => $file->path
                        ])
                        ?>
                    </td>
                    <td class="text-right">
                        <?php
                        if(!$file->isDir)
                        {
                            echo '<span class="text-muted">(' . $file->prettySize . ')</span> ';
                            echo $file->timeAgo;
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>

<?php if(!is_null($readme)):?>
    <div class="panel panel-default">
        <div class="panel-heading">
    <?= Html::a('<i class="glyphicon glyphicon-pencil"></i> ', ['/burivuh/main/update', 'path' => $readme->path], ['class' => 'btn btn-success btn-sm', 'tabindex' => 1])?>
            <b><?= $readme->name?></b>
            <div class="pull-right">
                <?= $readme->timeAgo?>
    <?= Html::a('<i class="glyphicon glyphicon-trash"></i> ', ['/burivuh/main/delete', 'path' => $readme->path], ['class' => 'btn btn-warning btn-sm'])?>
            </div>
        </div>
        <div class="panel-body"><?= $readme->markdown?></div>
    </div>
<?php endif;?>