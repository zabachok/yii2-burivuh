<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
        'id' => 'create-form',
    ]);
?>
<?= $form->errorSummary($model); ?>
<div class="input-group">        
    <?= Html::activeTextInput($model, 'title', ['tabindex' => 1, 'class' => 'form-control', 'placeholder'=>Yii::t('burivuh', 'Category name')])?>
    <span class="input-group-btn">
        <?= Html::submitButton(Yii::t('burivuh', 'Create'), ['class' => 'btn btn-success', 'tabindex' => 2])?>
    </span>
</div>
<?php ActiveForm::end();?>