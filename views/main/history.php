<?php
use yii\widgets\Breadcrumbs;

$this->title = 'Изменения документа "' . $model->title . '"';
$breadcrumbs = array_merge($model->getBreadcrumbs(1), [
    'label'=>'История',
]);
echo Breadcrumbs::widget([
    'links'    => $breadcrumbs,
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => '/burivuh/main/index'],
]);
$callback = \Yii::$app->getModule('burivuh')->usernameCallback;
?>
<h1><?=$this->title?></h1>
<table class="table">
    <tr>
        <th>Дата</th>
        <th>Заголовок</th>
        <th>Изменения</th>
        <th>Пользователь</th>
        <th></th>
    </tr>
    <?php
    foreach ($list as $item)
    {
        ?>
        <tr>
            <td><?=Yii::$app->formatter->asDatetime($item->created_at, 'medium')?></td>
            <td><?=$item->title?></td>
            <td><?=$item->diff?></td>
            <td><?=$callback($item->user_id)?></td>
            <td><?=\yii\helpers\Html::a('Смотреть разницу', ['/burivuh/main/diff', 'document_history_id'=>$item->document_history_id])?></td>
        </tr>
        <?php
    }
    ?>
</table>