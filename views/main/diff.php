<?php

use yii\widgets\Breadcrumbs;

$this->title = 'Изменение документа "' . $document->title . '"';

$breadcrumbs = array_merge($document->getBreadcrumbs(1), [[
    'label'=>'История',
    'url'=>['/burivuh/main/history', 'title'=>$document->title]
], [
    'label'=>'Изменение от ' . Yii::$app->formatter->asDatetime($model->created_at, 'medium')
]]);
echo Breadcrumbs::widget([
    'links'    => $breadcrumbs,
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => '/burivuh/main/index'],
]);
?>
<h1>Изменение документа "<?=$model->title?>"<br><small>от <?=Yii::$app->formatter->asDatetime($model->created_at, 'medium')?> </small></h1>

<?php
if(is_null($previous))
{
    echo 'Изменений нет';
    return;
}
?>
<div>
    Обозначения: <span class="bg-success text-success">добавленные</span>, <span class="bg-danger text-danger">удаленные</span>
</div>
<?php
foreach ($diffs as $diff)
{
    $color = '';
    if($diff[0] == -1) $color = 'bg-danger text-danger';
    if($diff[0] == 1) $color = 'bg-success text-success';
    if($diff[0] == 0) echo $diff[1];
    else echo '<span class="' . $color . '">' . $diff[1] . '</span>';
}
?>