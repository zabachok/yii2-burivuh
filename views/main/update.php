<?php

use yii\bootstrap\ActiveForm;

use yii\widgets\Breadcrumbs;

$form = ActiveForm::begin([
        'id' => 'update-form',
    ]);
echo Breadcrumbs::widget([
    'links'    => array_merge($model->getBreadcrumbs(1), [['label'=>'Редактирование']]),
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => '/burivuh/main/index'],
]);

echo $this->render('_form',[
    'model'=>$model,
]);

ActiveForm::end();
?>
