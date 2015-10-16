<?php

use yii\helpers\Html;

//use \backend\modules\solar\assets\ceres\CeresAsset;
//CeresAsset::register($this);

//$this->registerJsFile('/js/ceres.js', ['position' => 3, 'depends' => ['yii\web\JqueryAsset']]);
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="input-group">        
            <span class="input-group-btn">
                <?= Html::submitButton('&nbsp;<i class="glyphicon glyphicon-hdd"></i>&nbsp;', ['class' => 'btn btn-success', 'tabindex' => 3, 'id' => 'save_butoon'])?>
            </span>
            <?= Html::activeTextInput($model, 'name', ['tabindex' => 3, 'class' => 'form-control'])?>
            <span class="input-group-addon">
                <?= $model->timeAgo?>
            </span>
            <span class="input-group-btn">
                <?= Html::a('&nbsp;<i class="glyphicon glyphicon-eye-open"></i>&nbsp;', ['/solar/ceres/view', 'path' => $model->folder], ['class' => 'btn btn-warning'])?>
            </span>
        </div>
        <?= Html::error($model, 'name')?>
    </div>
    <?= Html::error($model, 'content')?>
    <?= Html::activeTextarea($model, 'content', ['class' => 'panel-body', 'style' => 'width:100%;height:800px;font-family: monospace;', 'id' => 'content', 'tabindex' => 2])?>
    <div class="panel-body">
    </div>
</div>