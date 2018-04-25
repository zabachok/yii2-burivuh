<?php

namespace zabachok\burivuh;

class Module extends \yii\base\Module
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

    public $usernameCallback;

    /**
     * @var string Routing prefix
     */
    public $route = 'burivuh';

    public function init()
    {
        if (is_null($this->usernameCallback)) {
            $this->usernameCallback = function ($user_id) {
                return $user_id;
            };
        }
    }
}
