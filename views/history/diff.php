<?php

use yii\widgets\Breadcrumbs;

$this->title = Yii::t('burivuh', 'Diff of document: {title}', [
    'title' => $model->title
]);

$breadcrumbs = array_merge($document->getBreadcrumbs(1), [
    [
        'label' => Yii::t('burivuh', 'History'),
        'url' => ['/burivuh/history/index', 'title' => $document->title, 'document_id' => $document->document_id]
    ],
    [
        'label' => Yii::t('burivuh', 'Change on {date}', [
            'date' => Yii::$app->formatter->asDatetime($model->created_at, 'medium')
        ]),
    ]
]);
echo Breadcrumbs::widget([
    'links' => $breadcrumbs,
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => ['/burivuh/category/index']],
]);
?>
    <h1><?= $this->title ?></h1>

<?php
if (is_null($previous)) {
    echo '<span class="bg-success text-success">' . str_replace("\n", '<br>', $model->content) . '</span>';
    return;
}
?>
    <div>
        <?= Yii::t('burivuh', 'Highlight') ?>: <span class="bg-success text-success"><?= Yii::t('burivuh',
                'added') ?></span>, <span class="bg-danger text-danger"><?= Yii::t('burivuh', 'removed') ?></span>
    </div>
<?php
foreach ($diffs as $diff) {
    $diff[1] = str_replace("\n", '<br>', $diff[1]);
    $color = '';
    if ($diff[0] == -1) {
        $color = 'bg-danger text-danger';
    }
    if ($diff[0] == 1) {
        $color = 'bg-success text-success';
    }
    if ($diff[0] == 0) {
        echo $diff[1];
    } else {
        echo '<span class="' . $color . '">' . $diff[1] . '</span>';
    }
}
?>