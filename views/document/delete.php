<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = Yii::t('burivuh', 'Delete document: {title}', [
    'title' => $model->title
]);
?>
<h1><?= $this->title ?></h1>

<div class="alert alert-danger">
    <b><?=Yii::t('burivuh', 'Remove document "{title}"?', ['title'=>$model->title])?></b><br><br>
    <?php $form = ActiveForm::begin([
        'id' => 'delete-category',
    ]);
    ?>
    <?= Html::hiddenInput('document_id', $model->document_id) ?>
    <?= Html::submitButton(Yii::t('burivuh', 'Delete'), ['class' => 'btn btn-danger']) ?>
    <?= Html::a(Yii::t('burivuh', 'Cancel'), $model->url, ['class' => 'btn btn-default']) ?>
    <?php ActiveForm::end(); ?>
</div>
