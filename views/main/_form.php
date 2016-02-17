<?php

use yii\helpers\Html;
use zabachok\burivuh\assets\BurivuhAsset;

BurivuhAsset::register($this);
$this->registerJs('burivuh.write.init();');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="input-group">        
            <span class="input-group-btn">
                <?= Html::submitButton('&nbsp;<i class="glyphicon glyphicon-hdd"></i>&nbsp;', ['class' => 'btn btn-success', 'tabindex' => 3, 'id' => 'burivuh-save-butoon', 'title'=>Yii::t('burivuh', 'Save')])?>
            </span>
            <?= Html::activeTextInput($model, 'title', ['tabindex' => 3, 'class' => 'form-control', 'placeholder'=>Yii::t('burivuh', 'File name')])?>
            <span class="input-group-addon">
                <?php // $model->timeAgo?>
            </span>
            <span class="input-group-btn">
                <?= Html::a('&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;', ['/burivuh/main/view', 'title' => $model->title], ['class' => 'btn btn-warning', 'title'=>Yii::t('burivuh', 'View')])?>
            </span>
        </div>
        <?= Html::error($model, 'name')?>
    </div>
    <?= Html::error($model, 'content')?>
    <?= Html::activeTextarea($model, 'content', ['class' => 'panel-body', 'style' => 'width:100%;height:800px;font-family: monospace;', 'id' => 'burivuh-content', 'tabindex' => 2])?>

</div>
<div class="row">
    <div class="col-md-12">
        <h2><?=Yii::t('burivuh', 'Hot keys')?></h2>
        <span class="label label-default">Ctrl</span> + <span class="label label-default">s</span> - <?=Yii::t('burivuh', 'save document')?><br>
        <span class="label label-default">Shift</span> + <span class="label label-default">Enter</span> - <?=Yii::t('burivuh', 'new line')?><br>
        <span class="label label-default">Tab</span> - <?=Yii::t('burivuh', 'four spaces')?>
    </div>
</div>