<?php

namespace zabachok\burivuh;

use Yii;

class Module extends \yii\base\Module
{

    public $controllerNamespace = 'zabachok\burivuh\controllers';
    public $defaultController   = 'default';
    
    public $db = 'db';
    public $usernameCallback;
    public $route = 'burivuh';
    public function init()
    {
        if(is_null($this->usernameCallback)) $this->usernameCallback = function($user_id){return $user_id; };
    }

}
