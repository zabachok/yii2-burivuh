<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = Yii::t('burivuh', 'Delete Category: {title}', [
    'title' => $model->title
]);
?>
<h1><?= $this->title ?></h1>

<div class="alert alert-danger">
    <b><?=Yii::t('burivuh', 'Remove category "{title}"?', ['title'=>$model->title])?></b><br><br>
    <?=Yii::t('burivuh', '<b>Attention!</b> All categories and documents in them will be deleted!')?>

    <?php $form = ActiveForm::begin([
        'id' => 'delete-category',
    ]);
    ?>
    <?= Html::hiddenInput('category_id', $model->category_id) ?>
    <?= Html::submitButton(Yii::t('burivuh', 'Delete'), ['class' => 'btn btn-danger']) ?>
    <?= Html::a(Yii::t('burivuh', 'Cancel'), $model->url, ['class' => 'btn btn-default']) ?>
    <?php ActiveForm::end(); ?>
</div>
