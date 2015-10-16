<?php

namespace zabachok\burivuh;

use Yii;

/**
 * Module [[Users]]
 * Yii2 users module.
 */
class Module extends \yii\base\Module
{

    public $controllerNamespace = 'zabachok\burivuh\controllers';
    public $defaultController   = 'default';
    
    public $filesPath;

    public function init()
    {
        parent::init();
//        \Yii::configure($this, require(__DIR__ . '/config.php'));

        // custom initialization code goes here
    }

}
