<?php

namespace zabachok\burivuh\assets;

use yii\web\AssetBundle;

class BurivuhAsset extends AssetBundle
{
    public $sourcePath = '@zabachok/burivuh/assets/';
    public $js = [
        'burivuh.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}