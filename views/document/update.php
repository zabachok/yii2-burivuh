<?php

use yii\bootstrap\ActiveForm;

use yii\widgets\Breadcrumbs;

$this->title = Yii::t('burivuh', 'Update document: {title}', [
    'title' => $model->title
]);

$form = ActiveForm::begin([
        'id' => 'update-form',
    ]);
echo Breadcrumbs::widget([
    'links'    => array_merge($model->getBreadcrumbs(1), [['label'=>'Редактирование']]),
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => ['/burivuh/category/index']],
]);

echo $this->render('_form',[
    'model'=>$model,
]);

ActiveForm::end();
?>
