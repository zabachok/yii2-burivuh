<?php

use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

$form = ActiveForm::begin([
    'id' => 'update-form',
]);

$this->title = Yii::t('burivuh', 'Create document');

$breadcrumbs = [
    [
        'label' => Yii::t('burivuh', 'Create document'),
    ],
];
if (!is_null($category)) {
    $breadcrumbs = array_merge($category->getBreadcrumbs(1), $breadcrumbs);
}
echo Breadcrumbs::widget([
    'links' => $breadcrumbs,
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => ['/burivuh/category/index']],
]);

echo $this->render('_form', [
    'model' => $model,
]);

ActiveForm::end();