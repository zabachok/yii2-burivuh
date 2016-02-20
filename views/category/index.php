<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use zabachok\burivuh\assets\BurivuhAsset;

BurivuhAsset::register($this);
$this->registerJs('burivuh.index.init();');
$this->title = $category->category_id == 0 ? Yii::t('burivuh', 'Root') : $category->title;

echo Breadcrumbs::widget([
    'links'    => isset($category->breadcrumbs) ? $category->breadcrumbs : [],
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => ['/burivuh/category/index']],
]);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= $this->title ?>
        <div class="btn-group pull-right">
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i>&nbsp;' . Yii::t('burivuh', 'Create document'),
                ['/burivuh/document/create', 'parent_id' => $category->category_id],
                ['class' => 'btn btn-success btn-xs']) ?>
            <?= Html::a('<i class="glyphicon glyphicon-plus"></i>&nbsp;' . Yii::t('burivuh', 'Create category'),
                ['/burivuh/category/create', 'parent_id' => $category->category_id],
                ['class' => 'btn btn-success btn-xs']) ?>
            <?php
            if ($category->category_id != 0)
            {
                echo Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp;' . Yii::t('burivuh', 'Delete category'),
                    ['/burivuh/category/delete', 'category_id' => $category->category_id],
                    ['class' => 'btn btn-warning btn-xs']);
            }
            ?>
        </div>
    </div>

    <table class="table table-striped dtable-bordered table-hover panel-body" id="burivuh-filelist">
        <?php
        if (empty($categories) && empty($documents))
        {
            echo '<tr class="warning"><td class="text-center">' . Yii::t('burivuh', 'Category is empty') . '</td></tr>';
        } else
        {
            foreach ($categories as $key => $category)
            {
                ?>
                <tr class="<?= $key == 0 ? 'active' : '' ?>">
                    <td>
                        <i class="glyphicon glyphicon-folder-close"></i>
                        <?= Html::a($category->title, $category->url, [
                            'class' => 'burivuh-line-link',
                        ]);
                        ?>
                    </td>
                    <td class="text-right">
                    </td>
                </tr>
                <?php
            }
            foreach ($documents as $key => $document)
            {
                ?>
                <tr class="<?= $key == 0 ? 'active' : '' ?>">
                    <td>
                        <i class="glyphicon glyphicon-file"></i>
                        <?= Html::a($document->title, $document->url, [
                            'class' => 'burivuh-line-link',
                        ]); ?>
                    </td>
                    <td class="text-right">
                        <?= $document->timeAgo ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
</div>

<?php if (!is_null($readme)) echo $this->render('_panel', ['model' => $readme]) ?>

<div class="row">
    <div class="col-md-12">
        <h2><?= Yii::t('burivuh', 'Hot keys') ?></h2>
        <span class="label label-default">&#8593;</span> or <span class="label label-default">&#8595;</span>
        - <?= Yii::t('burivuh', 'moving up and down in list') ?><br>
        <span class="label label-default">Enter</span> - <?= Yii::t('burivuh', 'open dir or file') ?><br>
    </div>
</div>