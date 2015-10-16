<?php

use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;

$form = ActiveForm::begin([
        'id' => 'update-form',
    ]);
echo Breadcrumbs::widget([
    'links'    => isset($breadcrumbs) ? $breadcrumbs : [],
    'homeLink' => false,
]);

echo $this->render('_form',[
    'model'=>$model,
]);

ActiveForm::end();
?>
