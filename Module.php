<?php

namespace zabachok\burivuh;

use Yii;

class Module extends \yii\base\Module
{

    public $controllerNamespace = 'zabachok\burivuh\controllers';
    public $defaultController   = 'default';
    
    public $db;
    public $usernameCallback;
    public function init()
    {
        if(is_null($this->db)) $this->db = Yii::$app->db;
    }

}
