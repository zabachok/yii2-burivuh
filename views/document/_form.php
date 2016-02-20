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
            <?= Html::activeTextInput($model, 'title', ['tabindex' => 1, 'class' => 'form-control', 'placeholder'=>Yii::t('burivuh', 'File name')])?>
            <span class="input-group-btn">
                <?= Html::a('&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;', $model->url, ['class' => 'btn btn-warning', 'title'=>Yii::t('burivuh', 'View')])?>
            </span>
        </div>
        <?= Html::error($model, 'name')?>
    </div>
    <div>
        <div class="btn-group">
            <button type="button" class="btn btn-default" onclick="burivuh.write.textFormatting.setHeader();">
                <i class="glyphicon glyphicon-header"></i>
            </button>
            <button type="button" class="btn btn-default" onclick="burivuh.write.textFormatting.setBold();">
                <i class="glyphicon glyphicon-bold"></i>
            </button>
            <button type="button" class="btn btn-default" onclick="burivuh.write.textFormatting.setItalic();">
                <i class="glyphicon glyphicon-italic"></i>
            </button>
            <button type="button" class="btn btn-default" onclick="burivuh.write.textFormatting.setBoldItalic();">
                <i class="glyphicon glyphicon-bold"></i>+<i class="glyphicon glyphicon-italic"></i>
            </button>
            <button type="button" class="btn btn-default" onclick="burivuh.write.textFormatting.setLink();">
                <i class="glyphicon glyphicon-link"></i>
            </button>
            <button type="button" class="btn btn-default" onclick="$('#burivuh-link-form').slideUp();$('#burivuh-picture-form').slideToggle();">
                <i class="glyphicon glyphicon-picture"></i>
            </button>
        </div>
        <div id="burivuh-link-form" style="display: none;">
            <div class="input-group">
                <span class="input-group-addon"><?=Yii::t('burivuh', 'Link label')?></span>
                <input type="text" class="form-control" name="label">
                <span class="input-group-addon"><?=Yii::t('burivuh', 'Link url')?></span>
                <input type="text" class="form-control" name="url">
                <div class="input-group-btn">
                    <div class="btn btn-primary" onclick="burivuh.write.textFormatting.insertLink()"><?=Yii::t('burivuh', 'Insert')?></div>
                </div>
            </div>
        </div>
        <div id="burivuh-picture-form" style="display: none;">
            <div class="input-group">
                <span class="input-group-addon"><?=Yii::t('burivuh', 'Picture label')?></span>
                <input type="text" class="form-control" name="alt">
                <span class="input-group-addon"><?=Yii::t('burivuh', 'Picture url')?></span>
                <input type="text" class="form-control" name="url">
                <div class="input-group-btn">
                    <div class="btn btn-primary" onclick="burivuh.write.textFormatting.insertPicture()"><?=Yii::t('burivuh', 'Insert')?></div>
                </div>
            </div>
        </div>

    </div>
    <?= Html::error($model, 'content')?>
    <?= Html::activeTextarea($model, 'content', ['class' => 'panel-body', 'style' => 'width:100%;height:800px;font-family: monospace;', 'id' => 'burivuh-content', 'tabindex' => 2])?>
    <div id="burivuh-write-preview"></div>
</div>
<div class="row">
    <div class="col-md-12">
        <h2><?=Yii::t('burivuh', 'Hot keys')?></h2>
        <span class="label label-default">Ctrl</span> + <span class="label label-default">s</span> - <?=Yii::t('burivuh', 'save document')?><br>
        <span class="label label-default">Shift</span> + <span class="label label-default">Enter</span> - <?=Yii::t('burivuh', 'new line')?><br>
        <span class="label label-default">Tab</span> - <?=Yii::t('burivuh', 'four spaces')?><br>
        <b><?=Yii::t('burivuh', 'Text formatting')?></b><br>

        <span class="label label-default">Ctrl</span> + <span class="label label-default">h</span> - <?=Yii::t('burivuh', 'Make this line a header')?><br>
    </div>
</div>