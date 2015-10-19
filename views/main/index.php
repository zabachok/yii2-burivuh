<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use zabachok\burivuh\assets\BurivuhAsset;

BurivuhAsset::register($this);
$this->registerJs('burivuh.index.init();');
$pathArray = explode('/', $path);
$dirName = end($pathArray);

echo Breadcrumbs::widget([
    'links'    => isset($breadcrumbs) ? $breadcrumbs : [],
    'homeLink' => false,
]);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= empty($dirName) ? Yii::t('burivuh', 'Root folder') : $dirName?>
        <div class="btn-group pull-right">
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i>&nbsp;' . Yii::t('burivuh', 'Create document'), ['/burivuh/main/create', 'path' => $path], ['class' => 'btn btn-success btn-xs'])?>
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i>&nbsp;' . Yii::t('burivuh', 'Create folder'), ['/burivuh/main/create-folder', 'path' => $path], ['class' => 'btn btn-success btn-xs'])?>
            <?= Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp;' . Yii::t('burivuh', 'Delete folder'), ['/burivuh/main/delete-folder', 'path' => $path], ['class' => 'btn btn-warning btn-xs'])?>
        </div>
    </div>

    <table class="table table-striped dtable-bordered table-hover panel-body" id="burivuh-filelist">
        <?php
        if(empty($folder)) echo '<tr class="warning"><td class="text-center">' . Yii::t('burivuh', 'Folder is empty') . '</td></tr>';
        else
        {
            foreach($folder as $key => $file)
            {
                if($key == 0 && $backDir !== null)
                {
                    echo '<tr><td colspan="2">';
                    echo Html::a('..', [
                        '/burivuh/main/index',
                        'path' => $backDir
                        ], [
                        'class' => 'burivuh-line-link',
                    ]);
                    echo '</tr></td>';
                }
                ?>
                <tr class="<?= $file->isDir ? 'active' : ''?>">
                    <td>
                        <?= $file->isDir ? '<i class="glyphicon glyphicon-folder-close"></i>' : '<i class="glyphicon glyphicon-file"></i>'?>
                        <?php
                        if($file->isDir)
                        {
                            echo Html::a($file->name, [
                                '/burivuh/main/index',
                                'path' => $file->path
                                ], [
                                'class' => 'burivuh-line-link',
                            ]);
                        }else
                        {
                            if($file->extension == 'md')
                            {
                                echo Html::a($file->filename, [
                                    '/burivuh/main/view',
                                    'path' => $file->path
                                    ], [
                                    'class' => 'burivuh-line-link',
                                ]);
                            }else
                            {
                                echo $file->filename;
                            }
                        }
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

<?php if(!is_null($readme)) echo $this->render('_panel', ['model' => $readme])?>

<div class="row">
    <div class="col-md-12">
        <h2><?= Yii::t('burivuh', 'Hot keys')?></h2>
        <span class="label label-default">&#8593;</span> or <span class="label label-default">&#8595;</span> - <?= Yii::t('burivuh', 'moving up and down in list')?><br>
        <span class="label label-default">Enter</span> - <?= Yii::t('burivuh', 'open dir or file')?><br>
    </div>
</div>