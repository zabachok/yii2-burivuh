<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$this->title = Yii::t('burivuh', 'Update category {title}', ['title'=>$model->title]);

$breadcrumbs = [
        ['label'=>$model->title, 'url'=>$model->url],
    [
        'label' => Yii::t('burivuh', 'Update category'),
    ],
];
if (!is_null($parent))
{
    $breadcrumbs = array_merge($parent->getBreadcrumbs(1), $breadcrumbs);
}
echo Breadcrumbs::widget([
    'links'    => $breadcrumbs,
    'homeLink' => ['label' => Yii::t('burivuh', 'Root'), 'url' => ['/burivuh/category/index']],
]);
?>

    <h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin([
    'id' => 'update-form',
]);
?>
<?= $form->errorSummary($model); ?>
    <div class="input-group">
        <?= Html::activeTextInput($model, 'title',
            ['tabindex' => 1, 'class' => 'form-control', 'placeholder' => Yii::t('burivuh', 'Category name')]) ?>
        <span class="input-group-btn">
        <?= Html::submitButton(Yii::t('burivuh', 'Update'), ['class' => 'btn btn-success', 'tabindex' => 2]) ?>
    </span>
    </div>
<?php ActiveForm::end(); ?>