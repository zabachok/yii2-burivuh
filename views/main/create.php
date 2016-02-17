<?php

use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

$form = ActiveForm::begin([
        'id' => 'update-form',
    ]);

    $breadcrumbs = [[
        'label'=>'Добавление документа'
    ]];
if(!is_null($category))
{
    $breadcrumbs = array_merge($category->getBreadcrumbs(1), $breadcrumbs);
}
echo Breadcrumbs::widget([
    'links'    => $breadcrumbs,
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => '/burivuh/main/index'],
]);

echo $this->render('_form',[
    'model'=>$model,
]);

ActiveForm::end();