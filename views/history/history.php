<?php

use yii\widgets\Breadcrumbs;

$this->title = Yii::t('burivuh', 'History of document: {title}', [
    'title' => $model->title
]);

$breadcrumbs = array_merge($model->getBreadcrumbs(1), [
    'label' => Yii::t('burivuh', 'History'),
]);
echo Breadcrumbs::widget([
    'links' => $breadcrumbs,
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => ['/burivuh/category/index']],
]);
$callback = \Yii::$app->getModule('burivuh')->usernameCallback;
?>
<h1><?= $this->title ?></h1>
<table class="table">
    <tr>
        <th><?= Yii::t('burivuh', 'Date') ?></th>
        <th><?= Yii::t('burivuh', 'Title') ?></th>
        <th><?= Yii::t('burivuh', 'Diff') ?></th>
        <th><?= Yii::t('burivuh', 'User') ?></th>
        <th></th>
    </tr>
    <?php
    foreach ($list as $item) {
        ?>
        <tr>
            <td><?= Yii::$app->formatter->asDatetime($item->created_at, 'medium') ?></td>
            <td><?= $item->title ?></td>
            <td><?= $item->diff ?></td>
            <td><?= $callback($item->user_id) ?></td>
            <td><?= \yii\helpers\Html::a(Yii::t('burivuh', 'See the difference'),
                    ['/burivuh/history/diff', 'id' => $item->document_history_id]) ?></td>
        </tr>
        <?php
    }
    ?>
</table>