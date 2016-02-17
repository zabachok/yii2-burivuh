<?php

namespace zabachok\burivuh;

use yii\base\BootstrapInterface;

/**
 * Users module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        // Add module URL rules.
        $app->urlManager->addRules(
            [
                'burivuh/category/<title:.*>'                                            => 'burivuh/main/index',
                'burivuh/doc/<title:.*>'                                                 => 'burivuh/main/view',
                'burivuh/<action:create|delete|update|create-folder|delete-folder>/<title:.*>' => 'burivuh/main/<action>',
                'burivuh'                                                                => 'burivuh/main/index',
            ], false
        );

        if (!isset($app->i18n->translations['burivuh']) && !isset($app->i18n->translations['burivuh*']))
        {
            $app->i18n->translations['burivuh'] = [
                'class'            => 'yii\i18n\PhpMessageSource',
                'basePath'         => '@zabachok/burivuh/messages',
                'forceTranslation' => true,
            ];

        }
    }

}
