<?php

namespace zabachok\burivuh;

use Yii;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module
{

    public $controllerNamespace = 'zabachok\burivuh\controllers';
    public $defaultController   = 'category';

    public $db          = 'db';
    public $usernameCallback;
    public $route       = 'burivuh';
    public $accessRules = [
        [
            'allow' => true,
            'roles' => ['@'],
        ],
    ];

    public function init()
    {
        if (is_null($this->usernameCallback))
        {
            $this->usernameCallback = function ($user_id) { return $user_id; };
        }
    }

}
