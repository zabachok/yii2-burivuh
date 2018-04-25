<?php

namespace zabachok\burivuh;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'zabachok\burivuh\controllers';

    /**
     * @inheritdoc
     */
    public $defaultController = 'category';

    /**
     * @var string DB connection component name
     */
    public $db = 'db';

    /**
     * @var callable Function getting user name
     */
    public $usernameCallback;

    /**
     * @var string Routing prefix
     */
    public $route = 'burivuh';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (is_null($this->usernameCallback)) {
            $this->usernameCallback = function ($userId) {
                return $userId;
            };
        }
    }
}
